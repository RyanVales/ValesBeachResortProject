<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'country_code',
        'date_of_birth',
        'gender',
        'nationality',
        'passport_number',
        'id_type',
        'id_number',
        'address',
        'city',
        'state_province',
        'postal_code',
        'country',
        'contact_preferences',
        'dietary_restrictions',
        'special_requests',
        'notes',
        'is_vip',
        'is_blacklisted',
        'preferred_language',
        'status',
        'last_stay_date',
        'total_stays',
        'total_spent',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'last_stay_date' => 'datetime',
        'contact_preferences' => 'array',
        'dietary_restrictions' => 'array',
        'special_requests' => 'array',
        'is_vip' => 'boolean',
        'is_blacklisted' => 'boolean',
        'total_spent' => 'decimal:2',
        'total_stays' => 'integer',
    ];

    // Relationships
    public function bookings()
    {
        return $this->hasMany(NewBooking::class);
    }

    // Accessors
    public function getFullNameAttribute()
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    public function getFormattedPhoneAttribute()
    {
        return $this->country_code . ' ' . $this->phone;
    }

    public function getAgeAttribute()
    {
        return $this->date_of_birth ? $this->date_of_birth->age : null;
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'active' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">✅ Active</span>',
            'inactive' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">⭕ Inactive</span>',
            'blacklisted' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">🚫 Blacklisted</span>',
        ];

        return $badges[$this->status] ?? $this->status;
    }

    public function getVipBadgeAttribute()
    {
        return $this->is_vip 
            ? '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">⭐ VIP</span>'
            : '';
    }

    public function getLastStayFormattedAttribute()
    {
        return $this->last_stay_date ? $this->last_stay_date->format('M d, Y') : 'Never';
    }

    public function getTotalSpentFormattedAttribute()
    {
        return '₱' . number_format($this->total_spent, 2);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeVip($query)
    {
        return $query->where('is_vip', true);
    }

    public function scopeByCountry($query, $country)
    {
        return $query->where('country', $country);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('first_name', 'LIKE', "%{$search}%")
              ->orWhere('last_name', 'LIKE', "%{$search}%")
              ->orWhere('email', 'LIKE', "%{$search}%")
              ->orWhere('phone', 'LIKE', "%{$search}%");
        });
    }

    // Helper Methods
    public function markAsVip()
    {
        $this->update(['is_vip' => true]);
    }

    public function removeVipStatus()
    {
        $this->update(['is_vip' => false]);
    }

    public function blacklist($reason = null)
    {
        $this->update([
            'status' => 'blacklisted',
            'is_blacklisted' => true,
            'notes' => $this->notes . "\n\nBlacklisted: " . $reason
        ]);
    }

    public function unblacklist()
    {
        $this->update([
            'status' => 'active',
            'is_blacklisted' => false
        ]);
    }

    public function updateStayStats($amount = 0)
    {
        $this->increment('total_stays');
        $this->increment('total_spent', $amount);
        $this->update(['last_stay_date' => now()]);
    }
}