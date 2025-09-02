@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Edit Employee</h1>
            <p class="text-gray-600 mt-1">Update employee information and settings</p>
        </div>
        <div class="space-x-2">
            <a href="{{ route('admin.employees.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                ← Back to Employees
            </a>
        </div>
    </div>

    <!-- Display validation errors -->
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <strong>Please fix the following errors:</strong>
            </div>
            <ul class="mt-2 ml-7 list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Employee Info Card -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center">
                <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white text-xl font-bold mr-4">
                    {{ substr($employee->name, 0, 1) }}
                </div>
                <div class="flex-1">
                    <h2 class="text-xl font-semibold text-gray-900">{{ $employee->name }}</h2>
                    <p class="text-gray-600">{{ $employee->email }}</p>
                    <div class="flex items-center mt-2 space-x-3">
                        <span class="text-sm text-gray-500">ID: {{ $employee->id }}</span>
                        @if($employee->is_blocked)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                🚫 Blocked
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                ✅ Active
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6">
            <form method="POST" action="{{ route('admin.employees.update', $employee) }}">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            👤 Full Name
                        </label>
                        <input type="text" 
                               name="name" 
                               id="name" 
                               value="{{ old('name', $employee->name) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                               placeholder="Enter full name"
                               required>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            📧 Email Address
                        </label>
                        <input type="email" 
                               name="email" 
                               id="email" 
                               value="{{ old('email', $employee->email) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                               placeholder="Enter email address"
                               required>
                    </div>

                    <!-- Role -->
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                            🏷️ Role
                        </label>
                        <select name="role" id="role" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" required>
                            <option value="">Select Role</option>
                            <option value="admin" {{ old('role', $employee->role) == 'admin' ? 'selected' : '' }}>👑 Administrator</option>
                            <option value="manager" {{ old('role', $employee->role) == 'manager' ? 'selected' : '' }}>👔 Manager</option>
                            <option value="staff" {{ old('role', $employee->role) == 'staff' ? 'selected' : '' }}>👥 Staff Member</option>
                            <option value="receptionist" {{ old('role', $employee->role) == 'receptionist' ? 'selected' : '' }}>🏨 Receptionist</option>
                            <option value="maintenance" {{ old('role', $employee->role) == 'maintenance' ? 'selected' : '' }}>🔧 Maintenance</option>
                        </select>
                    </div>

                    <!-- Current Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            ℹ️ Current Status
                        </label>
                        <div class="p-3 bg-gray-50 rounded-lg border">
                            @if($employee->is_blocked)
                                <div class="flex items-center space-x-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        🚫 Blocked
                                    </span>
                                    <span class="text-sm text-gray-600">
                                        Since: {{ $employee->blocked_at ? $employee->blocked_at->format('M d, Y') : 'Unknown' }}
                                    </span>
                                </div>
                                @if($employee->block_reason)
                                    <p class="text-sm text-red-600 mt-1">
                                        <strong>Reason:</strong> {{ $employee->block_reason }}
                                    </p>
                                @endif
                            @else
                                <div class="flex items-center space-x-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        ✅ Active
                                    </span>
                                    <span class="text-sm text-gray-600">Employee account is active</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
                    <div class="flex space-x-3">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                            💾 Update Employee
                        </button>
                        <a href="{{ route('admin.employees.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                            ❌ Cancel
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
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Employee Information Summary (Removed Email Status) -->
    <div class="bg-white rounded-lg shadow mt-6">
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">📊 Employee Information Summary</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="text-center">
                    <div class="text-2xl font-bold text-blue-600">{{ $employee->id }}</div>
                    <div class="text-sm text-gray-600">Employee ID</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-green-600">{{ $employee->created_at->format('M d, Y') }}</div>
                    <div class="text-sm text-gray-600">Date Created</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-purple-600">{{ $employee->updated_at->format('M d, Y') }}</div>
                    <div class="text-sm text-gray-600">Last Updated</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection