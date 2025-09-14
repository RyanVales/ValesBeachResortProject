@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.room-types.index') }}" 
                   class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">🏨 Add New Room Type</h1>
                    <p class="text-gray-600 mt-2">Create a new room category with pricing and amenities</p>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow-md">
            <form action="{{ route('admin.room-types.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Form Header -->
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Room Type Information</h2>
                    <p class="text-sm text-gray-600">Fill in the details for the new room type</p>
                </div>

                <div class="p-6 space-y-6">
                    <!-- Basic Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Room Type Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Facility Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror" 
                                   placeholder="e.g., Beer Garden"
                                   required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Guest Capacity (Updated to Input Field) -->
                        <div>
                            <label for="capacity" class="block text-sm font-medium text-gray-700 mb-2">
                                Guest Capacity <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="number" 
                                       id="capacity" 
                                       name="capacity" 
                                       value="{{ old('capacity') }}"
                                       class="w-full px-3 py-2 pr-16 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('capacity') border-red-500 @enderror" 
                                       placeholder="Enter number"
                                       required>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 text-sm">guests</span>
                                </div>
                            </div>
                            @error('capacity')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Description
                        </label>
                        <textarea id="description" 
                                  name="description" 
                                  rows="4" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror" 
                                  placeholder="Describe the room type, its features, and what makes it special...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Pricing -->
                    <div>
                        <label for="base_price" class="block text-sm font-medium text-gray-700 mb-2">
                            Base Price (per night) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">₱</span>
                            </div>
                            <input type="number" 
                                   id="base_price" 
                                   name="base_price" 
                                   step="0.01" 
                                   min="0" 
                                   value="{{ old('base_price') }}"
                                   class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('base_price') border-red-500 @enderror" 
                                   placeholder="0.00"
                                   required>
                        </div>
                        @error('base_price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">This is the standard nightly rate for this room type in Philippine Peso</p>
                    </div>

                    <!-- Amenities -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            Amenities
                        </label>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                            @php
                                $amenities = [
                                    'Free WiFi', 'Air Conditioning', 'TV', 'Mini Fridge', 
                                    'Ocean View', 'Balcony', 'Private Bathroom', 'Room Service',
                                    'Safe Box', 'Coffee Maker', 'Hair Dryer', 'Iron & Board',
                                    'Bathrobe', 'Slippers', 'Telephone', 'Wake-up Service',
                                    'Daily Housekeeping', 'Laundry Service', 'Concierge', 'Spa Access'
                                ];
                                $oldAmenities = old('amenities', []);
                            @endphp
                            
                            @foreach($amenities as $amenity)
                                <div class="flex items-center">
                                    <input type="checkbox" 
                                           id="amenity_{{ $loop->index }}" 
                                           name="amenities[]" 
                                           value="{{ $amenity }}"
                                           {{ in_array($amenity, $oldAmenities) ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                    <label for="amenity_{{ $loop->index }}" class="ml-2 text-sm text-gray-700">
                                        {{ $amenity }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        @error('amenities')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Image Upload -->
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                            Facility Image
                        </label>
                        <div class="flex items-center space-x-4">
                            <div class="flex-1">
                                <input type="file" 
                                       id="image" 
                                       name="image" 
                                       accept="image/*"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('image') border-red-500 @enderror">
                            </div>
                            <div class="flex-shrink-0">
                                <div id="image-preview" class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        @error('image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Upload a high-quality image (max 2MB, formats: JPG, PNG, GIF)</p>
                    </div>

                    <!-- Status -->
                    <div>
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   id="is_active" 
                                   name="is_active" 
                                   value="1"
                                   {{ old('is_active', true) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <label for="is_active" class="ml-2 text-sm text-gray-700">
                                <span class="font-medium">Active Room Type</span>
                                <span class="block text-gray-500">Enable this room type for bookings</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
                    <a href="{{ route('admin.room-types.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Cancel
                    </a>
                    
                    <div class="flex space-x-3">
                        <button type="submit" 
                                name="action" 
                                value="save_and_continue"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Save & Add Rooms
                        </button>
                        
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Save Room Type
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Image Preview Script -->
<script>
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('image-preview');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" class="w-16 h-16 rounded-lg object-cover">`;
        };
        reader.readAsDataURL(file);
    } else {
        preview.innerHTML = `
            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
        `;
    }
});

// Capacity validation
document.getElementById('capacity').addEventListener('input', function(e) {
    const value = parseInt(e.target.value);
    const input = e.target;
    
    if (value < 1) {
        input.setCustomValidity('Capacity must be at least 1 guest');
    } else if (value > 20) {
        input.setCustomValidity('Capacity cannot exceed 20 guests');
    } else {
        input.setCustomValidity('');
    }
});
</script>
@endsection