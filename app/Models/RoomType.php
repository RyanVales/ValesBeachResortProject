<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RoomType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'capacity',
        'base_price',
        'amenities',
        'image',
        'is_active',
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'amenities' => 'array',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function availableRooms()
    {
        return $this->hasMany(Room::class)->where('status', 'available')->where('is_active', true);
    }

    // Accessors
    public function getPriceFormattedAttribute()
    {
        return '$' . number_format($this->base_price, 2);
    }

    public function getAmenitiesListAttribute()
    {
        return $this->amenities ? implode(', ', $this->amenities) : 'No amenities listed';
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCapacity($query, $capacity)
    {
        return $query->where('capacity', '>=', $capacity);
    }
}