@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">🏠 Room Management</h2>
                        <p class="text-gray-600 mt-1">Manage individual rooms and their availability</p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.rooms.create') }}" 
                           class="bg-blue-600 text-white hover:bg-blue-700 px-4 py-2 rounded-lg text-sm font-medium">
                            ➕ Add Room
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6 text-center">
                <div class="text-3xl font-bold text-blue-600">{{ $rooms->total() }}</div>
                <div class="text-sm text-gray-500">Total Rooms</div>
            </div>
            <div class="bg-white rounded-lg shadow p-6 text-center">
                <div class="text-3xl font-bold text-green-600">{{ $rooms->where('status', 'available')->count() }}</div>
                <div class="text-sm text-gray-500">Available</div>
            </div>
            <div class="bg-white rounded-lg shadow p-6 text-center">
                <div class="text-3xl font-bold text-red-600">{{ $rooms->where('status', 'occupied')->count() }}</div>
                <div class="text-sm text-gray-500">Occupied</div>
            </div>
            <div class="bg-white rounded-lg shadow p-6 text-center">
                <div class="text-3xl font-bold text-yellow-600">{{ $rooms->where('status', 'maintenance')->count() }}</div>
                <div class="text-sm text-gray-500">Maintenance</div>
            </div>
        </div>

        <!-- Rooms Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            @if($rooms->count() > 0)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Room</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Floor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($rooms as $room)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-medium text-gray-900">{{ $room->room_number }}</div>
                                    @if($room->notes)
                                        <div class="text-sm text-gray-500">{{ Str::limit($room->notes, 30) }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $room->roomType->name ?? 'N/A' }}</div>
                                    <div class="text-sm text-gray-500">₱{{ number_format($room->roomType->base_price ?? 0, 2) }}/night</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $room->floor ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusColors = [
                                            'available' => 'bg-green-100 text-green-800',
                                            'occupied' => 'bg-red-100 text-red-800',
                                            'maintenance' => 'bg-yellow-100 text-yellow-800',
                                            'out_of_order' => 'bg-gray-100 text-gray-800'
                                        ];
                                        $statusIcons = [
                                            'available' => '✅',
                                            'occupied' => '🏠',
                                            'maintenance' => '🔧',
                                            'out_of_order' => '❌'
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$room->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ $statusIcons[$room->status] ?? '' }} {{ ucfirst(str_replace('_', ' ', $room->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.rooms.show', $room) }}" 
                                           class="text-blue-600 hover:text-blue-900">View</a>
                                        <a href="{{ route('admin.rooms.edit', $room) }}" 
                                           class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                @if($rooms->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $rooms->links() }}
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="px-6 py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No rooms found</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by creating your first room.</p>
                    <div class="mt-6">
                        <a href="{{ route('admin.rooms.create') }}" 
                           class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            ➕ Add Room
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection