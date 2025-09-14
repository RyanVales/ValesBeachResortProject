@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Welcome Header -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 text-gray-900">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Welcome back, {{ Auth::user()->name }}! 👋</h1>
                        <p class="text-gray-600 mt-1">Here's what's happening at Vales Beach Resort today.</p>
                        <div class="flex items-center mt-2 text-sm text-gray-500">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="capitalize">{{ Auth::user()->role }}</span>
                            <span class="mx-2">•</span>
                            <span>{{ Auth::user()->email }}</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">{{ now()->format('l, F j, Y') }}</p>
                        <p class="text-2xl font-bold text-blue-600">{{ now()->format('g:i A') }}</p>
                        <p class="text-xs text-gray-400">{{ now()->format('T') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Guests -->
            <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-blue-500 hover:shadow-md transition-shadow">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4 flex-1">
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Total Guests</h3>
                        <p class="text-2xl font-bold text-gray-900">0</p>
                        <p class="text-xs text-green-600 flex items-center mt-1">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd"></path>
                            </svg>
                            +0 today
                        </p>
                    </div>
                </div>
            </div>

            <!-- Room Types -->
            <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-green-500 hover:shadow-md transition-shadow">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                    <div class="ml-4 flex-1">
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Room Types</h3>
                        <p class="text-2xl font-bold text-gray-900">0</p>
                        <p class="text-xs text-blue-600 flex items-center mt-1">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            0 active
                        </p>
                    </div>
                </div>
            </div>

            <!-- Total Rooms -->
            <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-yellow-500 hover:shadow-md transition-shadow">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4 flex-1">
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Total Rooms</h3>
                        <p class="text-2xl font-bold text-gray-900">0</p>
                        <p class="text-xs text-green-600 flex items-center mt-1">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            0 available
                        </p>
                    </div>
                </div>
            </div>

            <!-- Staff Members -->
            <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-purple-500 hover:shadow-md transition-shadow">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4 flex-1">
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Staff Members</h3>
                        <p class="text-2xl font-bold text-gray-900">{{ \App\Models\User::count() }}</p>
                        <p class="text-xs text-indigo-600 flex items-center mt-1">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" clip-rule="evenodd"></path>
                            </svg>
                            {{ \App\Models\User::where('role', 'admin')->count() }} admins
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Management Cards -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Room Management -->
            <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 flex items-center">
                            🏨 Room Management
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">Manage room types, rooms, and availability</p>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.room-types.create') }}" 
                           class="bg-blue-600 text-white hover:bg-blue-700 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            Add Type
                        </a>
                        <a href="{{ route('admin.rooms.create') }}" 
                           class="bg-blue-100 text-blue-700 hover:bg-blue-200 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            Add Room
                        </a>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-6 mb-6">
                    <div class="text-center p-4 bg-blue-50 rounded-lg">
                        <div class="text-2xl font-bold text-blue-600">0</div>
                        <div class="text-sm text-gray-600">Room Types</div>
                        <div class="text-xs text-green-600 mt-1">0 active</div>
                    </div>
                    <div class="text-center p-4 bg-yellow-50 rounded-lg">
                        <div class="text-2xl font-bold text-yellow-600">0</div>
                        <div class="text-sm text-gray-600">Total Rooms</div>
                        <div class="text-xs text-green-600 mt-1">0 available</div>
                    </div>
                </div>

                <div class="flex space-x-4">
                    <a href="{{ route('admin.room-types.index') }}" 
                       class="flex-1 text-center py-2 px-4 bg-gray-100 text-gray-700 hover:bg-gray-200 rounded-lg text-sm font-medium transition-colors">
                        Manage Types
                    </a>
                    <a href="{{ route('admin.rooms.index') }}" 
                       class="flex-1 text-center py-2 px-4 bg-gray-100 text-gray-700 hover:bg-gray-200 rounded-lg text-sm font-medium transition-colors">
                        Manage Rooms
                    </a>
                </div>
            </div>

            <!-- Guest & Staff Management -->
            <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-purple-500">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 flex items-center">
                            👥 People Management
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">Manage guests and staff members</p>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.guests.create') }}" 
                           class="bg-purple-600 text-white hover:bg-purple-700 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            Add Guest
                        </a>
                        <a href="{{ route('admin.employees.create') }}" 
                           class="bg-purple-100 text-purple-700 hover:bg-purple-200 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            Add Staff
                        </a>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-6 mb-6">
                    <div class="text-center p-4 bg-purple-50 rounded-lg">
                        <div class="text-2xl font-bold text-purple-600">0</div>
                        <div class="text-sm text-gray-600">Total Guests</div>
                        <div class="text-xs text-yellow-600 mt-1">0 VIP</div>
                    </div>
                    <div class="text-center p-4 bg-indigo-50 rounded-lg">
                        <div class="text-2xl font-bold text-indigo-600">{{ \App\Models\User::count() }}</div>
                        <div class="text-sm text-gray-600">Staff Members</div>
                        <div class="text-xs text-green-600 mt-1">{{ \App\Models\User::where('role', 'admin')->count() }} admins</div>
                    </div>
                </div>

                <div class="flex space-x-4">
                    <a href="{{ route('admin.guests.index') }}" 
                       class="flex-1 text-center py-2 px-4 bg-gray-100 text-gray-700 hover:bg-gray-200 rounded-lg text-sm font-medium transition-colors">
                        Manage Guests
                    </a>
                    <a href="{{ route('admin.employees.index') }}" 
                       class="flex-1 text-center py-2 px-4 bg-gray-100 text-gray-700 hover:bg-gray-200 rounded-lg text-sm font-medium transition-colors">
                        Manage Staff
                    </a>
                </div>
            </div>
        </div>

        <!-- Bottom Section: Quick Actions, Recent Activity, System Status -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    ⚡ Quick Actions
                </h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.rooms.create') }}" 
                       class="flex items-center p-3 bg-gray-50 hover:bg-blue-50 hover:border-blue-200 border border-transparent rounded-lg transition-all duration-200">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Add New Room</p>
                            <p class="text-sm text-gray-500">Create individual room</p>
                        </div>
                    </a>

                    <a href="{{ route('admin.room-types.create') }}" 
                       class="flex items-center p-3 bg-gray-50 hover:bg-green-50 hover:border-green-200 border border-transparent rounded-lg transition-all duration-200">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Add Room Type</p>
                            <p class="text-sm text-gray-500">Create new category</p>
                        </div>
                    </a>

                    <a href="{{ route('admin.guests.create') }}" 
                       class="flex items-center p-3 bg-gray-50 hover:bg-purple-50 hover:border-purple-200 border border-transparent rounded-lg transition-all duration-200">
                        <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Add Guest</p>
                            <p class="text-sm text-gray-500">Register new guest</p>
                        </div>
                    </a>

                    <a href="{{ route('admin.employees.create') }}" 
                       class="flex items-center p-3 bg-gray-50 hover:bg-indigo-50 hover:border-indigo-200 border border-transparent rounded-lg transition-all duration-200">
                        <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Add Employee</p>
                            <p class="text-sm text-gray-500">Create staff account</p>
                        </div>
                    </a>

                    <a href="#" class="flex items-center p-3 bg-gray-50 hover:bg-yellow-50 hover:border-yellow-200 border border-transparent rounded-lg transition-all duration-200">
                        <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Create Booking</p>
                            <p class="text-sm text-gray-500">New reservation</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Getting Started Guide -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    🚀 Getting Started
                </h3>
                <div class="space-y-4">
                    <div class="text-center py-6">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Set up your resort</h4>
                        <p class="text-sm text-gray-500 mb-4">Start by creating room types and adding rooms to get your resort ready for guests.</p>
                        
                        <div class="space-y-2">
                            <a href="{{ route('admin.room-types.create') }}" 
                               class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m-6 0h6m0 0h6"></path>
                                </svg>
                                Create First Room Type
                            </a>
                            
                            <a href="{{ route('admin.guests.create') }}" 
                               class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                </svg>
                                Add First Guest
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Status & Today's Summary -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    🔧 System Status
                </h3>
                <div class="space-y-3 mb-6">
                    <div class="flex items-center justify-between p-2 bg-green-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                            <span class="text-sm text-gray-700">Database</span>
                        </div>
                        <span class="text-xs font-medium text-green-700 bg-green-100 px-2 py-1 rounded-full">Online</span>
                    </div>
                    <div class="flex items-center justify-between p-2 bg-green-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                            <span class="text-sm text-gray-700">Storage</span>
                        </div>
                        <span class="text-xs font-medium text-green-700 bg-green-100 px-2 py-1 rounded-full">Available</span>
                    </div>
                    <div class="flex items-center justify-between p-2 bg-blue-50 rounded-lg">
                        <span class="text-sm text-gray-700">Last Backup</span>
                        <span class="text-xs text-blue-700">{{ now()->subHours(2)->diffForHumans() }}</span>
                    </div>
                    <div class="flex items-center justify-between p-2 bg-gray-50 rounded-lg">
                        <span class="text-sm text-gray-700">Server Time</span>
                        <span class="text-xs text-gray-600 font-mono">{{ now()->format('H:i:s') }}</span>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-200">
                    <h4 class="text-sm font-bold text-gray-900 mb-3 flex items-center">
                        📊 Today's Summary
                    </h4>
                    <div class="space-y-2">
                        <div class="flex items-center text-sm">
                            <div class="w-2 h-2 bg-blue-500 rounded-full mr-2"></div>
                            <span class="text-gray-600">0 new guests registered</span>
                        </div>
                        <div class="flex items-center text-sm">
                            <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                            <span class="text-gray-600">0 active room types</span>
                        </div>
                        <div class="flex items-center text-sm">
                            <div class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></div>
                            <span class="text-gray-600">0 rooms available</span>
                        </div>
                        <div class="flex items-center text-sm">
                            <div class="w-2 h-2 bg-purple-500 rounded-full mr-2"></div>
                            <span class="text-gray-600">{{ \App\Models\User::count() }} staff members</span>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-4 border-t border-gray-200">
                    <a href="#" class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        View Full Report
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection