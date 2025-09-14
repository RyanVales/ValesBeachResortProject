@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Edit Room Type</h1>
            <p class="text-gray-600 mt-1">Update room type information, pricing and amenities</p>
        </div>
        <div class="space-x-2">
            <a href="{{ route('admin.room-types.show', $roomType) }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-200">
                👁️ View Details
            </a>
            <a href="{{ route('admin.room-types.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                ← Back to Room Types
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

    <!-- Room Type Info Card -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center">
                @if($roomType->image)
                    <img class="h-16 w-16 rounded-lg object-cover mr-4" src="{{ Storage::url($roomType->image) }}" alt="{{ $roomType->name }}">
                @else
                    <div class="h-16 w-16 rounded-lg bg-gray-200 flex items-center justify-center mr-4">
                        <span class="text-gray-500 text-xl">🏨</span>
                    </div>
                @endif
                <div class="flex-1">
                    <h2 class="text-xl font-semibold text-gray-900">{{ $roomType->name }}</h2>
                    <p class="text-gray-600">{{ $roomType->description ? Str::limit($roomType->description, 100) : 'No description available' }}</p>
                    <div class="flex items-center mt-2 space-x-3">
                        <span class="text-sm text-gray-500">ID: {{ $roomType->id }}</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            👥 {{ $roomType->capacity }} {{ Str::plural('guest', $roomType->capacity) }}
                        </span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            💰 ${{ number_format($roomType->base_price, 2) }}/night
                        </span>
                        @if($roomType->is_active)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                ✅ Active
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                ❌ Inactive
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
            <form method="POST" action="{{ route('admin.room-types.update', $roomType) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <!-- Room Type Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                🏨 Room Type Name
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name', $roomType->name) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                   placeholder="e.g., Standard Room, Deluxe Suite"
                                   required>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                📝 Description
                            </label>
                            <textarea name="description" 
                                      id="description" 
                                      rows="4"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                      placeholder="Describe the room type features and details...">{{ old('description', $roomType->description) }}</textarea>
                        </div>

                        <!-- Capacity and Price Row -->
                        <div class="grid grid-cols-2 gap-4">
                            <!-- Capacity -->
                            <div>
                                <label for="capacity" class="block text-sm font-medium text-gray-700 mb-2">
                                    👥 Max Capacity
                                </label>
                                <select name="capacity" id="capacity" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" required>
                                    <option value="">Select Capacity</option>
                                    @for($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}" {{ old('capacity', $roomType->capacity) == $i ? 'selected' : '' }}>
                                            {{ $i }} {{ Str::plural('Guest', $i) }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <!-- Base Price -->
                            <div>
                                <label for="base_price" class="block text-sm font-medium text-gray-700 mb-2">
                                    💰 Base Price (per night)
                                </label>
                                <div class="relative">
                                    <span class="absolute left-3 top-2 text-gray-500">$</span>
                                    <input type="number" 
                                           name="base_price" 
                                           id="base_price" 
                                           value="{{ old('base_price', $roomType->base_price) }}"
                                           step="0.01"
                                           min="0"
                                           class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                           placeholder="0.00"
                                           required>
                                </div>
                            </div>
                        </div>

                        <!-- Current Image Display -->
                        @if($roomType->image)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                🖼️ Current Image
                            </label>
                            <div class="flex items-center space-x-4">
                                <img class="h-20 w-20 rounded-lg object-cover border border-gray-200" src="{{ Storage::url($roomType->image) }}" alt="{{ $roomType->name }}">
                                <div class="text-sm text-gray-600">
                                    <p>Current room image</p>
                                    <p class="text-xs">Upload a new image to replace this one</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Room Image Upload -->
                        <div>
                            <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                                📷 {{ $roomType->image ? 'Update' : 'Add' }} Room Image
                            </label>
                            <div class="flex items-center justify-center w-full">
                                <label for="image" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to {{ $roomType->image ? 'replace' : 'upload' }}</span> room image</p>
                                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                                    </div>
                                    <input id="image" name="image" type="file" class="hidden" accept="image/*" />
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Amenities -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                ✨ Room Amenities
                            </label>
                            <div class="space-y-3">
                                <div id="amenities-container">
                                    @if($roomType->amenities && count($roomType->amenities) > 0)
                                        @foreach($roomType->amenities as $index => $amenity)
                                        <div class="flex items-center space-x-2 amenity-row {{ $index > 0 ? 'mt-2' : '' }}">
                                            <input type="text" 
                                                   name="amenities[]" 
                                                   value="{{ $amenity }}"
                                                   class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                   placeholder="Enter amenity">
                                            @if($index == 0)
                                                <button type="button" onclick="addAmenity()" class="px-3 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
                                                    ➕
                                                </button>
                                            @else
                                                <button type="button" onclick="removeAmenity(this)" class="px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                                                    ➖
                                                </button>
                                            @endif
                                        </div>
                                        @endforeach
                                    @else
                                        <div class="flex items-center space-x-2 amenity-row">
                                            <input type="text" 
                                                   name="amenities[]" 
                                                   class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                   placeholder="e.g., Free WiFi, Air Conditioning">
                                            <button type="button" onclick="addAmenity()" class="px-3 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
                                                ➕
                                            </button>
                                        </div>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-500">Add amenities one by one. Click + to add more.</p>
                            </div>
                        </div>

                        <!-- Quick Amenity Suggestions -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                💡 Quick Add Common Amenities
                            </label>
                            <div class="grid grid-cols-2 gap-2">
                                @php
                                $commonAmenities = [
                                    'Free WiFi', 'Air Conditioning', 'Private Bathroom', 'TV',
                                    'Mini Fridge', 'Coffee Maker', 'Room Service', 'Balcony',
                                    'Ocean View', 'King Size Bed', 'Work Desk', 'Safe Box'
                                ];
                                @endphp
                                @foreach($commonAmenities as $amenity)
                                <button type="button" 
                                        onclick="quickAddAmenity('{{ $amenity }}')"
                                        class="px-3 py-2 text-sm bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition duration-200">
                                    {{ $amenity }}
                                </button>
                                @endforeach
                            </div>
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                🔘 Status
                            </label>
                            <div class="flex items-center">
                                <input type="checkbox" 
                                       name="is_active" 
                                       id="is_active" 
                                       value="1"
                                       {{ old('is_active', $roomType->is_active) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="is_active" class="ml-2 block text-sm text-gray-900">
                                    Active (available for booking)
                                </label>
                            </div>
                        </div>

                        <!-- Room Count Info -->
                        <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                            <h4 class="font-semibold text-blue-900 mb-2">🏠 Associated Rooms</h4>
                            <div class="text-sm text-blue-800">
                                <p><strong>Total Rooms:</strong> {{ $roomType->rooms->count() }}</p>
                                <p><strong>Available:</strong> {{ $roomType->rooms->where('status', 'available')->count() }}</p>
                                <p><strong>Occupied:</strong> {{ $roomType->rooms->where('status', 'occupied')->count() }}</p>
                                @if($roomType->rooms->count() > 0)
                                    <a href="{{ route('admin.room-types.show', $roomType) }}" class="text-blue-600 hover:text-blue-800 underline">
                                        View all rooms →
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- Preview Card -->
                        <div class="bg-gray-50 rounded-lg p-4 border">
                            <h4 class="font-semibold text-gray-900 mb-2">🔍 Preview</h4>
                            <div class="text-sm text-gray-600 space-y-1">
                                <p><strong>Name:</strong> <span id="preview-name">{{ $roomType->name }}</span></p>
                                <p><strong>Capacity:</strong> <span id="preview-capacity">{{ $roomType->capacity }} guests</span></p>
                                <p><strong>Price:</strong> $<span id="preview-price">{{ number_format($roomType->base_price, 2) }}</span>/night</p>
                                <p><strong>Status:</strong> <span id="preview-status">{{ $roomType->is_active ? 'Active' : 'Inactive' }}</span></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
                    <div class="flex space-x-3">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                            💾 Update Room Type
                        </button>
                        <a href="{{ route('admin.room-types.show', $roomType) }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                            ❌ Cancel
                        </a>
                    </div>

                    <!-- Additional Actions -->
                    <div class="flex space-x-3">
                        <form method="POST" action="{{ route('admin.room-types.toggle', $roomType) }}" class="inline">
                            @csrf
                            <button type="submit" class="bg-{{ $roomType->is_active ? 'orange' : 'green' }}-600 text-white px-4 py-2 rounded-lg hover:bg-{{ $roomType->is_active ? 'orange' : 'green' }}-700 transition duration-200">
                                {{ $roomType->is_active ? '⏸️ Deactivate' : '▶️ Activate' }}
                            </button>
                        </form>
                        
                        @if($roomType->rooms->count() == 0)
                        <form method="POST" action="{{ route('admin.room-types.destroy', $roomType) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this room type? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-700 text-white px-4 py-2 rounded-lg hover:bg-red-800 transition duration-200">
                                🗑️ Delete Room Type
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Add new amenity input
function addAmenity() {
    const container = document.getElementById('amenities-container');
    const newRow = document.createElement('div');
    newRow.className = 'flex items-center space-x-2 amenity-row mt-2';
    newRow.innerHTML = `
        <input type="text" 
               name="amenities[]" 
               class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
               placeholder="Enter amenity">
        <button type="button" onclick="removeAmenity(this)" class="px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
            ➖
        </button>
    `;
    container.appendChild(newRow);
}

// Remove amenity input
function removeAmenity(button) {
    button.parentElement.remove();
}

// Quick add amenity
function quickAddAmenity(amenity) {
    const inputs = document.querySelectorAll('input[name="amenities[]"]');
    let added = false;
    
    // Check if amenity already exists
    for (let input of inputs) {
        if (input.value === amenity) {
            alert('This amenity is already added!');
            return;
        }
    }
    
    // Find empty input or add new one
    for (let input of inputs) {
        if (input.value === '') {
            input.value = amenity;
            added = true;
            break;
        }
    }
    
    if (!added) {
        addAmenity();
        const newInputs = document.querySelectorAll('input[name="amenities[]"]');
        newInputs[newInputs.length - 1].value = amenity;
    }
}

// Live preview updates
document.getElementById('name').addEventListener('input', function() {
    document.getElementById('preview-name').textContent = this.value || 'Room Type Name';
});

document.getElementById('capacity').addEventListener('change', function() {
    const capacity = this.value;
    document.getElementById('preview-capacity').textContent = capacity ? capacity + ' guests' : '- guests';
});

document.getElementById('base_price').addEventListener('input', function() {
    const price = parseFloat(this.value) || 0;
    document.getElementById('preview-price').textContent = price.toFixed(2);
});

document.getElementById('is_active').addEventListener('change', function() {
    document.getElementById('preview-status').textContent = this.checked ? 'Active' : 'Inactive';
});
</script>
@endsection