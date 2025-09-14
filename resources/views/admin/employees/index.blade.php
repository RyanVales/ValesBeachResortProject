@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Employee Management</h1>
        <div class="space-x-2">
            <a href="{{ route('admin.employees.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Add New Employee</a>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
        {{ session('error') }}
    </div>
    @endif

    <!-- Employee Statistics -->
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-center">
                <div class="text-2xl font-bold text-blue-600">{{ $employees->total() }}</div>
                <div class="text-sm text-gray-600">Total</div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-center">
                <div class="text-2xl font-bold text-green-600">{{ $employees->where('is_blocked', false)->count() }}</div>
                <div class="text-sm text-gray-600">Active</div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-center">
                <div class="text-2xl font-bold text-red-600">{{ $employees->where('is_blocked', true)->count() }}</div>
                <div class="text-sm text-gray-600">Blocked</div>
            </div>
        </div>
        @foreach(['admin' => 'Admin', 'manager' => 'Manager', 'staff' => 'Staff', 'receptionist' => 'Receptionist', 'maintenance' => 'Maintenance'] as $role => $label)
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-center">
                <div class="text-2xl font-bold text-purple-600">{{ $roleStats[$role] ?? 0 }}</div>
                <div class="text-sm text-gray-600">{{ $label }}</div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Filter Form -->
    <div class="bg-white p-6 rounded-lg shadow mb-6">
        <h3 class="text-lg font-semibold mb-4">Filter & Sort Employees</h3>
        <form method="GET" action="{{ route('admin.employees.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="blocked" {{ request('status') == 'blocked' ? 'selected' : '' }}>Blocked</option>
                </select>
            </div>

            <!-- Role Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                <select name="role" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All Roles</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="manager" {{ request('role') == 'manager' ? 'selected' : '' }}>Manager</option>
                    <option value="staff" {{ request('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                    <option value="receptionist" {{ request('role') == 'receptionist' ? 'selected' : '' }}>Receptionist</option>
                    <option value="housekeeper" {{ request('role') == 'housekeeper' ? 'selected' : '' }}>Housekeeper</option>
                    <option value="maintenance" {{ request('role') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                </select>
            </div>
            
            <!-- Name Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <input type="text" name="name" placeholder="Search by name..." 
                       value="{{ request('name') }}" 
                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            
            <!-- Email Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="text" name="email" placeholder="Search by email..." 
                       value="{{ request('email') }}" 
                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Sort Options -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
                <select name="sort_by" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Date Added</option>
                    <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Name</option>
                    <option value="email" {{ request('sort_by') == 'email' ? 'selected' : '' }}>Email</option>
                    <option value="role" {{ request('sort_by') == 'role' ? 'selected' : '' }}>Role</option>
                </select>
            </div>
            
            <!-- Filter Buttons -->
            <div class="md:col-span-5 flex gap-2">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition-colors">
                    Apply Filters
                </button>
                <a href="{{ route('admin.employees.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400 transition-colors">
                    Clear All
                </a>
            </div>
        </form>
    </div>

    <!-- Employees Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Added</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($employees as $employee)
                <tr class="hover:bg-gray-50 {{ $employee->is_blocked ? 'bg-red-50' : '' }}">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="h-10 w-10 rounded-full {{ $employee->is_blocked ? 'bg-red-300' : 'bg-gray-300' }} flex items-center justify-center">
                                <span class="text-sm font-medium text-gray-700">
                                    {{ substr($employee->name, 0, 2) }}
                                </span>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $employee->name }}</div>
                                @if($employee->is_blocked && $employee->block_reason)
                                <div class="text-xs text-red-600">{{ $employee->block_reason }}</div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $employee->email }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full 
                            @if($employee->role == 'admin') bg-red-100 text-red-800
                            @elseif($employee->role == 'manager') bg-purple-100 text-purple-800
                            @elseif($employee->role == 'receptionist') bg-blue-100 text-blue-800
                            @elseif($employee->role == 'housekeeper') bg-green-100 text-green-800
                            @elseif($employee->role == 'maintenance') bg-yellow-100 text-yellow-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ ucfirst($employee->role ?? 'staff') }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @if($employee->is_blocked)
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                            🚫 Blocked
                        </span>
                        @if($employee->blocked_at)
                        <div class="text-xs text-gray-500 mt-1">{{ $employee->blocked_at->format('M j, Y') }}</div>
                        @endif
                        @else
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                            ✅ Active
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $employee->created_at->format('M j, Y') }}</td>
                    <td class="px-6 py-4 text-sm font-medium">
                        <div class="flex flex-wrap gap-1">
                            <a href="{{ route('admin.employees.show', $employee->id) }}" 
                               class="text-blue-600 hover:text-blue-900 text-xs bg-blue-50 px-2 py-1 rounded">View</a>
                            <a href="{{ route('admin.employees.edit', $employee->id) }}" 
                               class="text-indigo-600 hover:text-indigo-900 text-xs bg-indigo-50 px-2 py-1 rounded">Edit</a>
                            
                            @if($employee->id !== auth()->id())
                                @if($employee->is_blocked)
                                    <!-- Unblock Button -->
                                    <form action="{{ route('admin.employees.unblock', $employee->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="text-green-600 hover:text-green-900 text-xs bg-green-50 px-2 py-1 rounded"
                                                onclick="return confirm('Are you sure you want to unblock {{ $employee->name }}?')">
                                            Unblock
                                        </button>
                                    </form>
                                @else
                                    <!-- Block Button -->
                                    <a href="{{ route('admin.employees.block.form', $employee->id) }}" 
                                       class="text-yellow-600 hover:text-yellow-900 text-xs bg-yellow-50 px-2 py-1 rounded">Block</a>
                                @endif
                                
                                <!-- Delete Button -->
                                <form action="{{ route('admin.employees.destroy', $employee->id) }}" method="POST" class="inline" 
                                      onsubmit="return confirm('Are you sure you want to delete this employee?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 text-xs bg-red-50 px-2 py-1 rounded">Delete</button>
                                </form>
                            @else
                                <span class="text-gray-400 text-xs">Current User</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="text-gray-500">
                            <p class="text-lg font-medium">No employees found</p>
                            <p class="mt-1">Try adjusting your filters or add a new employee.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($employees->hasPages())
    <div class="mt-6">
        {{ $employees->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection