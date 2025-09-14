<?php
// filepath: app/Models/NewBooking.php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class NewBooking extends Model
{
    use HasFactory;

    protected $table = 'bookings'; // Use the bookings table we created

    protected $fillable = [
        'booking_reference',
        'guest_id',
        'room_id',
        'created_by',
        'check_in_date',
        'check_out_date',
        'nights',
        'adults',
        'children',
        'room_rate',
        'total_amount',
        'paid_amount',
        'balance',
        'status',
        'confirmed_at',
        'checked_in_at',
        'checked_out_at',
        'cancelled_at',
        'special_requests',
        'staff_notes',
        'services',
    ];

    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date',
        'room_rate' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'balance' => 'decimal:2',
        'confirmed_at' => 'datetime',
        'checked_in_at' => 'datetime',
        'checked_out_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'services' => 'array',
    ];

    // Relationships
    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Auto-generate booking reference
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            if (empty($booking->booking_reference)) {
                $booking->booking_reference = 'VBR-' . strtoupper(Str::random(8));
            }

            // Calculate nights
            if ($booking->check_in_date && $booking->check_out_date) {
                $booking->nights = $booking->check_in_date->diffInDays($booking->check_out_date);
            }

            // Calculate balance
            $booking->balance = $booking->total_amount - $booking->paid_amount;
        });
    }
}