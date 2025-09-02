@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Employee Details</h1>
            <p class="text-gray-600 mt-1">Complete employee information and account status</p>
        </div>
        <div class="space-x-2">
            <a href="{{ route('admin.employees.edit', $employee) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                ✏️ Edit Employee
            </a>
            <a href="{{ route('admin.employees.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                ← Back to Employees
            </a>
        </div>
    </div>

    <!-- Employee Profile Card -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-20 h-20 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white text-2xl font-bold mr-6">
                        {{ substr($employee->name, 0, 1) }}
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">{{ $employee->name }}</h2>
                        <p class="text-gray-600 text-lg">{{ $employee->email }}</p>
                        <div class="flex items-center mt-2 space-x-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                🆔 ID: {{ $employee->id }}
                            </span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                @if($employee->role == 'admin') 👑
                                @elseif($employee->role == 'manager') 👔
                                @elseif($employee->role == 'staff') 👥
                                @elseif($employee->role == 'receptionist') 🏨
                                @elseif($employee->role == 'maintenance') 🔧
                                @endif
                                {{ ucfirst($employee->role) }}
                            </span>
                            @if($employee->is_blocked)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    🚫 Blocked
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    ✅ Active
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Employee Statistics (matching your index style) -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-center">
                <div class="text-2xl font-bold text-blue-600">{{ $employee->id }}</div>
                <div class="text-sm text-gray-600">Employee ID</div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-center">
                <div class="text-2xl font-bold text-green-600">{{ $employee->created_at->diffInDays() }}</div>
                <div class="text-sm text-gray-600">Days Active</div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-center">
                <div class="text-2xl font-bold {{ $employee->is_blocked ? 'text-red-600' : 'text-green-600' }}">
                    {{ $employee->is_blocked ? '🚫' : '✅' }}
                </div>
                <div class="text-sm text-gray-600">Status</div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-center">
                <div class="text-2xl font-bold {{ $employee->email_verified_at ? 'text-green-600' : 'text-yellow-600' }}">
                    {{ $employee->email_verified_at ? '✅' : '⏳' }}
                </div>
                <div class="text-sm text-gray-600">Email</div>
            </div>
        </div>
    </div>

    <!-- Information Cards -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Basic Information -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">👤 Basic Information</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500 uppercase tracking-wide">Full Name</label>
                        <p class="mt-1 text-lg font-semibold text-gray-900">{{ $employee->name }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500 uppercase tracking-wide">Email Address</label>
                        <p class="mt-1 text-lg text-gray-900">{{ $employee->email }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500 uppercase tracking-wide">Role</label>
                        <p class="mt-1 text-lg text-gray-900">
                            @if($employee->role == 'admin') 👑 Administrator
                            @elseif($employee->role == 'manager') 👔 Manager
                            @elseif($employee->role == 'staff') 👥 Staff Member
                            @elseif($employee->role == 'receptionist') 🏨 Receptionist
                            @elseif($employee->role == 'maintenance') 🔧 Maintenance
                            @else {{ ucfirst($employee->role) }}
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500 uppercase tracking-wide">Email Verification</label>
                        <p class="mt-1">
                            @if($employee->email_verified_at)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    ✅ Verified on {{ $employee->email_verified_at->format('M d, Y') }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    ⏳ Not Verified
                                </span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Account Status -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">🛡️ Account Status</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500 uppercase tracking-wide">Current Status</label>
                        @if($employee->is_blocked)
                            <div class="mt-2 p-4 bg-red-50 border border-red-200 rounded-lg">
                                <div class="flex items-center">
                                    <span class="text-red-600 text-lg mr-2">🚫</span>
                                    <div>
                                        <p class="text-red-800 font-semibold">Account Blocked</p>
                                        @if($employee->block_reason)
                                            <p class="text-red-600 text-sm mt-1">{{ $employee->block_reason }}</p>
                                        @endif
                                        @if($employee->blocked_at)
                                            <p class="text-red-500 text-xs mt-1">
                                                Blocked on {{ $employee->blocked_at->format('F d, Y \a\t H:i A') }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="mt-2 p-4 bg-green-50 border border-green-200 rounded-lg">
                                <div class="flex items-center">
                                    <span class="text-green-600 text-lg mr-2">✅</span>
                                    <div>
                                        <p class="text-green-800 font-semibold">Account Active</p>
                                        <p class="text-green-600 text-sm">Employee can access the system</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Account Timeline (Removed Email Status) -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">⏰ Account Timeline</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-green-600 text-xl">➕</span>
                    </div>
                    <h4 class="font-semibold text-gray-900">Account Created</h4>
                    <p class="text-gray-600">{{ $employee->created_at->format('F d, Y') }}</p>
                    <p class="text-gray-500 text-sm">{{ $employee->created_at->format('H:i A') }}</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-blue-600 text-xl">📝</span>
                    </div>
                    <h4 class="font-semibold text-gray-900">Last Updated</h4>
                    <p class="text-gray-600">{{ $employee->updated_at->format('F d, Y') }}</p>
                    <p class="text-gray-500 text-sm">{{ $employee->updated_at->format('H:i A') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex flex-col sm:flex-row justify-between items-center mt-6 space-y-4 sm:space-y-0">
        <div class="flex space-x-3">
            <a href="{{ route('admin.employees.edit', $employee) }}" 
               class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                ✏️ Edit Employee
            </a>
        </div>

        <!-- Block/Unblock Actions -->
        <div class="flex space-x-3">
            @if($employee->is_blocked)
                <form method="POST" action="{{ route('admin.employees.unblock', $employee) }}" class="inline">
                    @csrf
                    <button type="submit" 
                            class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-200"
                            onclick="return confirm('Are you sure you want to unblock this employee?')">
                        🔓 Unblock Employee
                    </button>
                </form>
            @else
                <a href="{{ route('admin.employees.block.form', $employee) }}" 
                   class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition duration-200">
                    🚫 Block Employee
                </a>
            @endif
            
            <form method="POST" action="{{ route('admin.employees.destroy', $employee) }}" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="bg-red-700 text-white px-4 py-2 rounded-lg hover:bg-red-800 transition duration-200"
                        onclick="return confirm('Are you sure you want to delete this employee? This action cannot be undone.')">
                    🗑️ Delete Employee
                </button>
            </form>
        </div>
    </div>
</div>
@endsection