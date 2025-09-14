<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_type_id',
        'room_number',
        'floor',
        'status',
        'notes',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // AUTO-LOGIC: Ensure room is inactive if status is not available
    protected static function boot()
    {
        parent::boot();
        
        static::saving(function ($room) {
            // If status is not available, force inactive
            if ($room->status !== 'available') {
                $room->is_active = false;
            }
        });
    }
    
    // Relationships
    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    public function newBookings()
    {
        return $this->hasMany(NewBooking::class);
    }

    // Accessors
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'available' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">✅ Available</span>',
            'occupied' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">🏨 Occupied</span>',
            'maintenance' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">🔧 Maintenance</span>',
            'out_of_order' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">❌ Out of Order</span>',
        ];

        return $badges[$this->status] ?? $this->status;
    }

    public function getFullDetailsAttribute()
    {
        $roomTypeName = $this->roomType ? $this->roomType->name : 'No Type';
        return "Room {$this->room_number} ({$roomTypeName})";
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available')->where('is_active', true);
    }

    public function scopeByFloor($query, $floor)
    {
        return $query->where('floor', $floor);
    }

    public function scopeByType($query, $roomTypeId)
    {
        return $query->where('room_type_id', $roomTypeId);
    }

    // Helper Methods
    public function isAvailable()
    {
        return $this->status === 'available' && $this->is_active;
    }

    public function canBook()
    {
        return $this->isAvailable();
    }
}