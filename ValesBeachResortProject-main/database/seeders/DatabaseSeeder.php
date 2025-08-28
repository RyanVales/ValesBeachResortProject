<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Booking;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user (matching your existing MySQL user)
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        // Create regular user (matching your existing MySQL user)
        User::create([
            'name' => 'Regular User',
            'email' => 'regular@example.com',
            'role' => 'staff',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        // Create additional staff users for demo purposes
        User::create([
            'name' => 'John Receptionist',
            'email' => 'john@valesbeachresort.com',
            'role' => 'receptionist',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Sarah Manager',
            'email' => 'sarah@valesbeachresort.com',
            'role' => 'manager',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Mike Housekeeper',
            'email' => 'mike@valesbeachresort.com',
            'role' => 'housekeeper',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Lisa Maintenance',
            'email' => 'lisa@valesbeachresort.com',
            'role' => 'maintenance',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        // Create sample bookings
        Booking::create([
            'guest_name' => 'John Doe',
            'guest_email' => 'john.doe@email.com',
            'guest_phone' => '+1-555-0123',
            'room_number' => '101',
            'room_type' => 'Ocean View',
            'check_in' => '2025-02-15',
            'check_out' => '2025-02-20',
            'guests' => 2,
            'status' => 'confirmed',
            'total_amount' => 1250.00,
            'special_requests' => 'Late check-in requested',
        ]);

        Booking::create([
            'guest_name' => 'Jane Smith',
            'guest_email' => 'jane.smith@email.com',
            'guest_phone' => '+1-555-0124',
            'room_number' => '205',
            'room_type' => 'Deluxe Suite',
            'check_in' => '2025-02-18',
            'check_out' => '2025-02-22',
            'guests' => 4,
            'status' => 'pending',
            'total_amount' => 1980.00,
            'special_requests' => 'Connecting rooms for family',
        ]);

        Booking::create([
            'guest_name' => 'Mike Johnson',
            'guest_email' => 'mike.johnson@email.com',
            'guest_phone' => '+1-555-0125',
            'room_number' => '308',
            'room_type' => 'Presidential Suite',
            'check_in' => '2025-02-10',
            'check_out' => '2025-02-14',
            'guests' => 2,
            'status' => 'checked_out',
            'total_amount' => 2850.00,
            'special_requests' => null,
        ]);

        Booking::create([
            'guest_name' => 'Emily Davis',
            'guest_email' => 'emily.davis@email.com',
            'guest_phone' => '+1-555-0126',
            'room_number' => '102',
            'room_type' => 'Ocean View',
            'check_in' => '2025-03-01',
            'check_out' => '2025-03-05',
            'guests' => 1,
            'status' => 'confirmed',
            'total_amount' => 800.00,
            'special_requests' => 'Ground floor room preferred',
        ]);

        Booking::create([
            'guest_name' => 'Robert Wilson',
            'guest_email' => 'robert.wilson@email.com',
            'guest_phone' => '+1-555-0127',
            'room_number' => '401',
            'room_type' => 'Presidential Suite',
            'check_in' => '2025-02-25',
            'check_out' => '2025-03-02',
            'guests' => 2,
            'status' => 'pending',
            'total_amount' => 3500.00,
            'special_requests' => 'Anniversary celebration',
        ]);
    }
}