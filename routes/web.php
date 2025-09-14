<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomTypeController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\RoomController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

// Dashboard - Accessible to all authenticated users
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile Routes - Accessible to all authenticated users
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Management Routes - All Authenticated Users Can Access
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    // Admin Dashboard
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    
    // Room Types Management (All authenticated users)
    Route::resource('room-types', RoomTypeController::class);
    Route::post('room-types/{roomType}/toggle', [RoomTypeController::class, 'toggle'])->name('room-types.toggle');
    
    // Room Management (All authenticated users)
    Route::resource('rooms', RoomController::class);
    Route::post('rooms/{room}/status', [RoomController::class, 'updateStatus'])->name('rooms.update-status');
    Route::get('rooms/bulk/create', [RoomController::class, 'bulkCreate'])->name('rooms.bulk-create');
    Route::post('rooms/bulk/store', [RoomController::class, 'bulkStore'])->name('rooms.bulk-store');
    
    // Guest Management (All authenticated users)
    Route::resource('guests', GuestController::class);
    Route::post('guests/{guest}/toggle-vip', [GuestController::class, 'toggleVip'])->name('guests.toggle-vip');
    Route::post('guests/{guest}/blacklist', [GuestController::class, 'blacklist'])->name('guests.blacklist');
    Route::post('guests/{guest}/unblacklist', [GuestController::class, 'unblacklist'])->name('guests.unblacklist');
    
    // Employee Management (All authenticated users)
    Route::resource('employees', EmployeeController::class);
    Route::post('employees/{employee}/block', [EmployeeController::class, 'block'])->name('employees.block');
    Route::post('employees/{employee}/unblock', [EmployeeController::class, 'unblock'])->name('employees.unblock');
    Route::get('employees/{employee}/block-form', [EmployeeController::class, 'showBlockForm'])->name('employees.block.form');
});

/*
|--------------------------------------------------------------------------
| API Routes for AJAX Calls
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('api')->name('api.')->group(function () {
    
    // Room availability check - all authenticated users
    Route::post('rooms/check-availability', function () {
        return response()->json(['available' => true]);
    })->name('rooms.check-availability');
    
    // Quick room status update
    Route::post('rooms/{room}/quick-status', [RoomController::class, 'quickStatusUpdate'])->name('rooms.quick-status');
    
    // Guest search
    Route::get('guests/search', [GuestController::class, 'search'])->name('guests.search');
});

/*
|--------------------------------------------------------------------------
| Debug Routes (Remove in Production)
|--------------------------------------------------------------------------
*/
if (app()->environment('local')) {
    // Test route to check user roles
    Route::get('/test-role', function () {
        if (auth()->check()) {
            return 'User: ' . auth()->user()->name . ' | Role: ' . auth()->user()->role;
        }
        return 'Not authenticated';
    })->middleware('auth');
}

// Include authentication routes
require __DIR__.'/auth.php';