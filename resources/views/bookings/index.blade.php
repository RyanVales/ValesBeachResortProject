<!DOCTYPE html>
<html>
<head>
    <title>Bookings - Vales Beach Resort</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Bookings Management</h1>
            <div class="space-x-2">
                <a href="{{ route('admin.dashboard') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">Back to Dashboard</a>
                <a href="{{ route('bookings.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Add New Booking</a>
            </div>
        </div>
        
        <!-- Filter Form -->
        <div class="bg-white p-6 rounded-lg shadow mb-6">
            <h3 class="text-lg font-semibold mb-4">Filter Bookings</h3>
            <form method="GET" action="{{ route('bookings.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="checked_in" {{ request('status') == 'checked_in' ? 'selected' : '' }}>Checked In</option>
                        <option value="checked_out" {{ request('status') == 'checked_out' ? 'selected' : '' }}>Checked Out</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                
                <!-- Guest Name Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Guest Name</label>
                    <input type="text" name="guest_name" placeholder="Search guest name..." 
                           value="{{ request('guest_name') }}" 
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <!-- Room Number Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Room Number</label>
                    <input type="text" name="room_number" placeholder="Room number..." 
                           value="{{ request('room_number') }}" 
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <!-- Recent Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Time Period</label>
                    <select name="recent" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Time</option>
                        <option value="1" {{ request('recent') == '1' ? 'selected' : '' }}>Recent (Last 30 days)</option>
                    </select>
                </div>
                
                <!-- Filter Buttons -->
                <div class="md:col-span-4 flex gap-2">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition-colors">
                        Apply Filters
                    </button>
                    <a href="{{ route('bookings.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400 transition-colors">
                        Clear All
                    </a>
                </div>
            </form>
        </div>

        <!-- Results Summary -->
        <div class="mb-4">
            <p class="text-gray-600">
                Showing {{ $bookings->count() }} 
                @if($bookings instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    of {{ $bookings->total() }} 
                @endif
                bookings
                @if(request()->hasAny(['status', 'guest_name', 'room_number', 'recent']))
                    <span class="font-semibold">(filtered)</span>
                @endif
            </p>
        </div>

        <!-- Bookings Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Guest</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Room</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Check-in</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Check-out</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Booked</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($bookings as $booking)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ $booking->guest_name }}</div>
                                <div class="text-sm text-gray-500">{{ $booking->guest_email }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $booking->room_number }}</div>
                            <div class="text-sm text-gray-500">{{ $booking->room_type }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            {{ \Carbon\Carbon::parse($booking->check_in)->format('M j, Y') }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            {{ \Carbon\Carbon::parse($booking->check_out)->format('M j, Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                @if($booking->status == 'confirmed') bg-green-100 text-green-800
                                @elseif($booking->status == 'pending') bg-yellow-100 text-yellow-800
                                @elseif($booking->status == 'checked_in') bg-blue-100 text-blue-800
                                @elseif($booking->status == 'checked_out') bg-gray-100 text-gray-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            ${{ number_format($booking->total_amount, 2) }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($booking->created_at)->format('M j, Y') }}
                        </td>
                        <td class="px-6 py-4 text-sm font-medium space-x-2">
                            <a href="{{ route('bookings.show', $booking->id) }}" class="text-blue-600 hover:text-blue-900">View</a>
                            <a href="{{ route('bookings.edit', $booking->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <div class="text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                <p class="text-lg font-medium">No bookings found</p>
                                <p class="mt-1">Try adjusting your filters or create a new booking.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

</body>
</html>