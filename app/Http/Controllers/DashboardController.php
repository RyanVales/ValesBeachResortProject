<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Redirect admin users to admin dashboard
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        
        // Staff dashboard data
        $totalStaff = User::where('role', '!=', 'admin')->count();
        $totalBookings = 24; // You can replace this with actual booking model count
        $monthlyRevenue = 12450; // You can replace this with actual revenue calculation
        $availableRooms = 18; // You can replace this with actual room model count
        
        return view('dashboard', compact('user', 'totalStaff', 'totalBookings', 'monthlyRevenue', 'availableRooms'));
    }
}