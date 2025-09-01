<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Customer welcome page (for registered customers)
Route::middleware(['auth'])->get('/customer/welcome', function () {
    return view('customer.welcome');
})->name('customer.welcome');

// Logout route
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Staff dashboard routes (admin-created accounts only) - Using CheckDashboardAccess middleware
Route::middleware(['auth', 'verified', \App\Http\Middleware\PreventBackHistory::class, \App\Http\Middleware\CheckDashboardAccess::class])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Booking routes (staff only)
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::get('/bookings/{booking}/edit', [BookingController::class, 'edit'])->name('bookings.edit');
    Route::patch('/bookings/{booking}', [BookingController::class, 'update'])->name('bookings.update');
    Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');
});

// Profile management routes (all authenticated users can edit their profile)
Route::middleware(['auth', \App\Http\Middleware\PreventBackHistory::class, \App\Http\Middleware\CheckIfBlocked::class])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes (staff only) - Using CheckDashboardAccess middleware
Route::middleware(['auth', \App\Http\Middleware\PreventBackHistory::class, \App\Http\Middleware\CheckDashboardAccess::class])->prefix('admin')->name('admin.')->group(function () {
    // Admin dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Staff management routes
    Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
    Route::get('/staff/create', [StaffController::class, 'create'])->name('staff.create');
    Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');
    Route::get('/staff/{user}/edit', [StaffController::class, 'edit'])->name('staff.edit');
    Route::put('/staff/{user}', [StaffController::class, 'update'])->name('staff.update');
    Route::delete('/staff/{user}', [StaffController::class, 'destroy'])->name('staff.destroy');
    
    // Employee management routes
    Route::resource('employees', EmployeeController::class);
    
    // Block/Unblock routes
    Route::get('/employees/{employee}/block', [EmployeeController::class, 'showBlockForm'])->name('employees.block.form');
    Route::post('/employees/{employee}/block', [EmployeeController::class, 'block'])->name('employees.block');
    Route::post('/employees/{employee}/unblock', [EmployeeController::class, 'unblock'])->name('employees.unblock');
});

// Include authentication routes
require __DIR__.'/auth.php';