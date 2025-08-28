@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Staff Management</h1>
                    <p class="text-gray-600 mt-2">Manage your resort staff members by their specific roles</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                        </svg>
                        Back to Dashboard
                    </a>
                    <a href="{{ route('staff.create') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                        </svg>
                        Add New Staff
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6">
                <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4 mb-8">
            <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-blue-500">
                <div class="text-center">
                    <h3 class="text-xs font-medium text-gray-500 uppercase">Total Staff</h3>
                    <p class="text-xl font-semibold text-gray-900">{{ $staff->count() }}</p>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-green-500">
                <div class="text-center">
                    <h3 class="text-xs font-medium text-gray-500 uppercase">Managers</h3>
                    <p class="text-xl font-semibold text-gray-900">{{ $staff->where('role', 'manager')->count() }}</p>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-blue-400">
                <div class="text-center">
                    <h3 class="text-xs font-medium text-gray-500 uppercase">Receptionists</h3>
                    <p class="text-xl font-semibold text-gray-900">{{ $staff->where('role', 'receptionist')->count() }}</p>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-purple-500">
                <div class="text-center">
                    <h3 class="text-xs font-medium text-gray-500 uppercase">Housekeepers</h3>
                    <p class="text-xl font-semibold text-gray-900">{{ $staff->where('role', 'housekeeper')->count() }}</p>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-yellow-500">
                <div class="text-center">
                    <h3 class="text-xs font-medium text-gray-500 uppercase">Concierges</h3>
                    <p class="text-xl font-semibold text-gray-900">{{ $staff->where('role', 'concierge')->count() }}</p>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-red-500">
                <div class="text-center">
                    <h3 class="text-xs font-medium text-gray-500 uppercase">Maintenance</h3>
                    <p class="text-xl font-semibold text-gray-900">{{ $staff->where('role', 'maintenance')->count() }}</p>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-orange-500">
                <div class="text-center">
                    <h3 class="text-xs font-medium text-gray-500 uppercase">Other</h3>
                    <p class="text-xl font-semibold text-gray-900">{{ $staff->whereIn('role', ['chef', 'security'])->count() }}</p>
                </div>
            </div>
        </div>

        <!-- Staff Table -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Staff Members</h2>
            </div>
            
            @if($staff->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Staff Member</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Position</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($staff as $member)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center">
                                                <span class="text-sm font-medium text-white">{{ strtoupper(substr($member->name, 0, 1)) }}</span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $member->name }}</div>
                                            <div class="text-sm text-gray-500">ID: {{ $member->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ 
                                        $member->role === 'manager' ? 'bg-green-100 text-green-800' : 
                                        ($member->role === 'receptionist' ? 'bg-blue-100 text-blue-800' : 
                                        ($member->role === 'housekeeper' ? 'bg-purple-100 text-purple-800' :
                                        ($member->role === 'concierge' ? 'bg-yellow-100 text-yellow-800' :
                                        ($member->role === 'maintenance' ? 'bg-red-100 text-red-800' :
                                        ($member->role === 'chef' ? 'bg-orange-100 text-orange-800' :
                                        ($member->role === 'security' ? 'bg-gray-100 text-gray-800' : 'bg-gray-100 text-gray-800')))))) 
                                    }}">
                                        {{ 
                                            $member->role === 'manager' ? '🏢 Manager' : 
                                            ($member->role === 'receptionist' ? '🏨 Receptionist' : 
                                            ($member->role === 'housekeeper' ? '🧹 Housekeeper' :
                                            ($member->role === 'concierge' ? '🎩 Concierge' :
                                            ($member->role === 'maintenance' ? '🔧 Maintenance' :
                                            ($member->role === 'chef' ? '👨‍🍳 Chef' :
                                            ($member->role === 'security' ? '🛡️ Security' : ucfirst($member->role))))))) 
                                        }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $member->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $member->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('staff.edit', $member) }}" 
                                           class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 px-3 py-1 rounded-md transition-colors">
                                            Edit
                                        </a>
                                        <form action="{{ route('staff.destroy', $member) }}" 
                                              method="POST" 
                                              style="display: inline-block;"
                                              onsubmit="return confirm('Are you sure you want to delete {{ $member->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-3 py-1 rounded-md transition-colors">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M34 40h10v-4a6 6 0 00-10.712-3.714M34 40H14m20 0v-4a9.971 9.971 0 00-.712-3.714M14 40H4v-4a6 6 0 0110.712-3.714M14 40v-4a9.971 9.971 0 01.712-3.714M28 16a4 4 0 11-8 0 4 4 0 018 0zM24 24a6 6 0 100-12 6 6 0 000 12zM40 16a4 4 0 11-8 0 4 4 0 018 0zM8 16a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No staff members</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by adding your first staff member.</p>
                    <div class="mt-6">
                        <a href="{{ route('staff.create') }}" 
                           class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                            </svg>
                            Add Staff Member
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection