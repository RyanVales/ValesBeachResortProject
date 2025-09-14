@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">🏠 Add New Room</h2>
                        <p class="text-gray-600 mt-1">Create a new room for your resort</p>
                    </div>
                    <a href="{{ route('admin.rooms.index') }}" 
                       class="bg-gray-600 text-white hover:bg-gray-700 px-4 py-2 rounded-lg text-sm font-medium">
                        ← Back to Rooms
                    </a>
                </div>

                <form method="POST" action="{{ route('admin.rooms.store') }}" class="space-y-6">
                    @csrf

                    <!-- Room Number -->
                    <div>
                        <label for="room_number" class="block text-sm font-medium text-gray-700">Room Number *</label>
                        <input type="text" 
                               name="room_number" 
                               id="room_number" 
                               value="{{ old('room_number') }}"
                               placeholder="e.g., 101, A101, VIP01"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('room_number') border-red-500 @enderror">
                        @error('room_number')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Room Type -->
                    <div>
                        <label for="room_type_id" class="block text-sm font-medium text-gray-700">Room Type *</label>
                        <select name="room_type_id" 
                                id="room_type_id" 
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('room_type_id') border-red-500 @enderror">
                            <option value="">Select a room type</option>
                            @foreach($roomTypes as $type)
                                <option value="{{ $type->id }}" {{ old('room_type_id') == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }} - ₱{{ number_format($type->base_price, 2) }}/night
                                </option>
                            @endforeach
                        </select>
                        @error('room_type_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Floor -->
                    <div>
                        <label for="floor" class="block text-sm font-medium text-gray-700">Floor</label>
                        <input type="text" 
                               name="floor" 
                               id="floor" 
                               value="{{ old('floor') }}"
                               placeholder="e.g., 1st Floor, Ground Floor, 2F"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('floor') border-red-500 @enderror">
                        @error('floor')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Initial Status *</label>
                        <select name="status" 
                                id="status" 
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('status') border-red-500 @enderror"
                                onchange="handleStatusChange()">
                            <option value="available" {{ old('status', 'available') == 'available' ? 'selected' : '' }}>✅ Available</option>
                            <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>🔧 Maintenance</option>
                            <option value="out_of_order" {{ old('status') == 'out_of_order' ? 'selected' : '' }}>❌ Out of Order</option>
                            <option value="occupied" {{ old('status') == 'occupied' ? 'selected' : '' }}>🏠 Occupied</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">
                            <span id="status-info">✅ Available rooms can be set as active and bookable</span>
                        </p>
                    </div>

                    <!-- Notes -->
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                        <textarea name="notes" 
                                  id="notes" 
                                  rows="3"
                                  placeholder="Any special notes about this room..."
                                  class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('notes') border-red-500 @enderror">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                 

                    <!-- Auto-Inactive Warning -->
                    <div id="inactive-warning" class="hidden mt-2 p-3 bg-yellow-50 border border-yellow-200 rounded-md">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-800">
                                    <strong>Auto-Inactive Policy:</strong> Rooms with status other than "Available" are automatically set as inactive and not bookable. This ensures only ready rooms can receive bookings.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-end space-x-3 pt-6">
                        <a href="{{ route('admin.rooms.index') }}" 
                           class="bg-gray-600 text-white hover:bg-gray-700 px-6 py-2 rounded-lg text-sm font-medium">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="bg-blue-600 text-white hover:bg-blue-700 px-6 py-2 rounded-lg text-sm font-medium">
                            ✅ Create Room
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Quick Help Card -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <h3 class="text-sm font-medium text-blue-800 mb-2">💡 Room Status Guide:</h3>
            <div class="text-sm text-blue-700 space-y-1">
                <div><strong>✅ Available:</strong> Room is ready for guests and can be booked</div>
                <div><strong>🔧 Maintenance:</strong> Room needs cleaning/repairs - automatically inactive</div>
                <div><strong>❌ Out of Order:</strong> Room has issues and cannot be used - automatically inactive</div>
                <div><strong>🏠 Occupied:</strong> Room is currently in use by guests - automatically inactive</div>
            </div>
        </div>

        <!-- Bulk Create Link -->
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600 mb-3">Need to create multiple rooms at once?</p>
            <a href="#" 
               class="inline-flex items-center px-4 py-2 bg-green-100 text-green-700 hover:bg-green-200 rounded-lg text-sm font-medium transition-colors">
                📦 Use Bulk Room Creator
                <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </a>
        </div>
    </div>
</div>

<script>
function handleStatusChange() {
    const statusSelect = document.getElementById('status');
    const isActiveCheckbox = document.getElementById('is_active');
    const activeLabel = document.getElementById('active-label');
    const statusInfo = document.getElementById('status-info');
    const inactiveWarning = document.getElementById('inactive-warning');
    
    const status = statusSelect.value;
    
    if (status === 'available') {
        // Available: Allow active checkbox
        isActiveCheckbox.disabled = false;
        isActiveCheckbox.checked = true;
        activeLabel.textContent = 'Room is active and bookable';
        statusInfo.innerHTML = '✅ Available rooms can be set as active and bookable';
        statusInfo.className = 'mt-1 text-sm text-green-600';
        inactiveWarning.classList.add('hidden');
    } else {
        // Non-available: Force inactive
        isActiveCheckbox.disabled = true;
        isActiveCheckbox.checked = false;
        activeLabel.textContent = 'Room will be automatically set as inactive (not bookable)';
        
        const statusMessages = {
            'maintenance': '🔧 Maintenance rooms are automatically inactive and not bookable',
            'out_of_order': '❌ Out of order rooms are automatically inactive and not bookable',
            'occupied': '🏠 Occupied rooms are automatically inactive and not bookable'
        };
        
        statusInfo.innerHTML = statusMessages[status] || '⚠️ Non-available rooms are automatically inactive';
        statusInfo.className = 'mt-1 text-sm text-yellow-600 font-medium';
        inactiveWarning.classList.remove('hidden');
    }
}

// Run on page load to set initial state
document.addEventListener('DOMContentLoaded', function() {
    handleStatusChange();
});

// Add visual feedback for form validation
document.getElementById('room_number').addEventListener('input', function() {
    const value = this.value.trim();
    const isValid = value.length >= 1;
    
    if (isValid) {
        this.classList.remove('border-red-500');
        this.classList.add('border-green-500');
    } else {
        this.classList.remove('border-green-500');
        this.classList.add('border-red-500');
    }
});

document.getElementById('room_type_id').addEventListener('change', function() {
    const isValid = this.value !== '';
    
    if (isValid) {
        this.classList.remove('border-red-500');
        this.classList.add('border-green-500');
    } else {
        this.classList.remove('border-green-500');
        this.classList.add('border-red-500');
    }
});
</script>
@endsection