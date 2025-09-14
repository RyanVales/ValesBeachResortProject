@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <div class="flex items-center space-x-4">
                <div class="h-12 w-12 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center">
                    <span class="text-lg font-medium text-white">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Edit Staff Member</h1>
                    <p class="text-gray-600 mt-1">Update {{ $user->name }}'s information</p>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Staff Information</h2>
                        <p class="text-sm text-gray-600">Make changes to staff member details</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ 
                            $user->role === 'manager' ? 'bg-green-100 text-green-800' : 
                            ($user->role === 'receptionist' ? 'bg-blue-100 text-blue-800' : 
                            ($user->role === 'housekeeper' ? 'bg-purple-100 text-purple-800' :
                            ($user->role === 'concierge' ? 'bg-yellow-100 text-yellow-800' :
                            ($user->role === 'maintenance' ? 'bg-red-100 text-red-800' :
                            ($user->role === 'chef' ? 'bg-orange-100 text-orange-800' :
                            ($user->role === 'security' ? 'bg-gray-100 text-gray-800' : 'bg-gray-100 text-gray-800')))))) 
                        }}">
                            Current: {{ ucfirst($user->role) }}
                        </span>
                    </div>
                </div>
            </div>
            
            <form method="POST" action="{{ route('staff.update', $user) }}" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                            Full Name
                        </span>
                    </label>
                    <input type="text" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-300 @enderror" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $user->name) }}" 
                           placeholder="Enter full name"
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                            </svg>
                            Email Address
                        </span>
                    </label>
                    <input type="email" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-300 @enderror" 
                           id="email" 
                           name="email" 
                           value="{{ old('email', $user->email) }}" 
                           placeholder="Enter email address"
                           required>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-1">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z"></path>
                            </svg>
                            Job Position
                        </span>
                    </label>
                    <select class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('role') border-red-300 @enderror" 
                            id="role" 
                            name="role" 
                            required>
                        <option value="">Select a position</option>
                        <option value="manager" {{ old('role', $user->role) === 'manager' ? 'selected' : '' }}>
                            🏢 Manager - Department management and oversight
                        </option>
                        <option value="receptionist" {{ old('role', $user->role) === 'receptionist' ? 'selected' : '' }}>
                            🏨 Receptionist - Front desk and guest services
                        </option>
                        <option value="housekeeper" {{ old('role', $user->role) === 'housekeeper' ? 'selected' : '' }}>
                            🧹 Housekeeper - Room cleaning and maintenance
                        </option>
                        <option value="concierge" {{ old('role', $user->role) === 'concierge' ? 'selected' : '' }}>
                            🎩 Concierge - Guest assistance and recommendations
                        </option>
                        <option value="maintenance" {{ old('role', $user->role) === 'maintenance' ? 'selected' : '' }}>
                            🔧 Maintenance - Property repairs and upkeep
                        </option>
                        <option value="chef" {{ old('role', $user->role) === 'chef' ? 'selected' : '' }}>
                            👨‍🍳 Chef - Kitchen and food services
                        </option>
                        <option value="security" {{ old('role', $user->role) === 'security' ? 'selected' : '' }}>
                            🛡️ Security - Property safety and surveillance
                        </option>
                    </select>
                    @error('role')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Account Info -->
                <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Account Information</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    <li>Account created: {{ $user->created_at->format('F j, Y \a\t g:i A') }}</li>
                                    <li>Last updated: {{ $user->updated_at->format('F j, Y \a\t g:i A') }}</li>
                                    <li>Password will remain unchanged unless you create a password reset function</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-between pt-6 border-t border-gray-200">
                    <div class="flex space-x-3">
                        <a href="{{ route('staff.index') }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                            </svg>
                            Cancel
                        </a>
                        
                        <button type="button" 
                                onclick="showDeleteConfirmation()"
                                class="inline-flex items-center px-4 py-2 border border-red-300 rounded-md shadow-sm text-sm font-medium text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            Delete Staff
                        </button>
                    </div>
                    
                    <button type="submit" 
                            class="inline-flex items-center px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        Update Staff Member
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-4">Delete Staff Member</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Are you sure you want to delete <strong>{{ $user->name }}</strong>? This action cannot be undone and will permanently remove their account and all associated data.
                </p>
            </div>
            <div class="items-center px-4 py-3">
                <form action="{{ route('staff.destroy', $user) }}" method="POST" style="display: inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-24 mr-2 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
                        Delete
                    </button>
                </form>
                <button onclick="hideDeleteConfirmation()" 
                        class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-24 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function showDeleteConfirmation() {
    document.getElementById('deleteModal').classList.remove('hidden');
}

function hideDeleteConfirmation() {
    document.getElementById('deleteModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        hideDeleteConfirmation();
    }
});
</script>
@endsection