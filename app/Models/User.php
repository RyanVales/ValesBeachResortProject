<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_blocked',
        'blocked_at',
        'block_reason',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_blocked' => 'boolean',
            'blocked_at' => 'datetime',
        ];
    }

    /**
     * Check if user is blocked
     */
    public function isBlocked(): bool
    {
        return $this->is_blocked;
    }

    /**
     * Block the user
     */
    public function block(string $reason = null): void
    {
        $this->update([
            'is_blocked' => true,
            'blocked_at' => now(),
            'block_reason' => $reason,
        ]);
    }

    /**
     * Unblock the user
     */
    public function unblock(): void
    {
        $this->update([
            'is_blocked' => false,
            'blocked_at' => null,
            'block_reason' => null,
        ]);
    }

    /**
     * Get status text
     */
    public function getStatusAttribute(): string
    {
        return $this->is_blocked ? 'Blocked' : 'Active';
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is manager
     */
    public function isManager(): bool
    {
        return $this->role === 'manager';
    }

    /**
     * Check if user is staff (any staff role)
     */
    public function isStaff(): bool
    {
        return in_array($this->role, ['admin', 'manager', 'staff', 'receptionist']);
    }

    /**
     * Check if user is customer
     */
    public function isCustomer(): bool
    {
        return $this->role === 'customer';
    }

    /**
     * Check if user can access dashboard (staff only)
     */
    public function canAccessDashboard(): bool
    {
        return $this->isStaff();
    }

    /**
     * Check if user can manage employees (admin and manager only)
     */
    public function canManageEmployees(): bool
    {
        return in_array($this->role, ['admin', 'manager']);
    }

    /**
     * Check if user can block/unblock other users (admin only)
     */
    public function canBlockUsers(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Get role display name
     */
    public function getRoleDisplayAttribute(): string
    {
        return match($this->role) {
            'admin' => 'Administrator',
            'manager' => 'Manager',
            'staff' => 'Staff Member',
            'receptionist' => 'Receptionist',
            'customer' => 'Customer',
            default => 'Unknown'
        };
    }

    /**
     * Get available roles for selection
     */
    public static function getAvailableRoles(): array
    {
        return [
            'admin' => 'Administrator',
            'manager' => 'Manager',
            'staff' => 'Staff Member',
            'receptionist' => 'Receptionist',
            'customer' => 'Customer',
        ];
    }

    /**
     * Get staff roles only (excluding customer)
     */
    public static function getStaffRoles(): array
    {
        return [
            'admin' => 'Administrator',
            'manager' => 'Manager',
            'staff' => 'Staff Member',
            'receptionist' => 'Receptionist',
        ];
    }
}