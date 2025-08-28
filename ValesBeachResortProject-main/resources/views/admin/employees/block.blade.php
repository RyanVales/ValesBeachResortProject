@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Block User Account</h1>
            <a href="{{ route('admin.employees.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                Back to Employees
            </a>
        </div>

        <!-- Warning -->
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">
                        <strong>Warning:</strong> You are about to block {{ $employee->name }}'s account. They will be immediately logged out and unable to access the system until unblocked.
                    </p>
                </div>
            </div>
        </div>

        <!-- Employee Info -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Employee Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-500">Name</label>
                    <p class="text-lg text-gray-900">{{ $employee->name }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500">Email</label>
                    <p class="text-lg text-gray-900">{{ $employee->email }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500">Role</label>
                    <span class="px-2 py-1 text-sm font-semibold rounded-full bg-gray-100 text-gray-800">
                        {{ ucfirst($employee->role ?? 'staff') }}
                    </span>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500">Status</label>
                    <span class="px-2 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                        Currently Active
                    </span>
                </div>
            </div>
        </div>

        <!-- Block Form -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <form method="POST" action="{{ route('admin.employees.block', $employee->id) }}">
                @csrf

                <!-- Block Reason -->
                <div class="mb-6">
                    <label for="block_reason" class="block text-sm font-medium text-gray-700 mb-2">
                        Reason for Blocking <span class="text-gray-400">(Optional)</span>
                    </label>
                    <textarea id="block_reason" 
                              name="block_reason" 
                              rows="4"
                              class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                              placeholder="Enter the reason for blocking this user account...">{{ old('block_reason') }}</textarea>
                    <p class="text-gray-500 text-xs mt-1">This reason will be visible to other administrators and can help with future reference.</p>
                    @error('block_reason')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Common Reasons -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Quick Reasons</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <button type="button" onclick="setReason('Violation of company policy')" 
                                class="text-left p-2 border border-gray-300 rounded hover:bg-gray-50 text-sm">
                            Violation of company policy
                        </button>
                        <button type="button" onclick="setReason('Unauthorized access attempts')" 
                                class="text-left p-2 border border-gray-300 rounded hover:bg-gray-50 text-sm">
                            Unauthorized access attempts
                        </button>
                        <button type="button" onclick="setReason('Security concerns')" 
                                class="text-left p-2 border border-gray-300 rounded hover:bg-gray-50 text-sm">
                            Security concerns
                        </button>
                        <button type="button" onclick="setReason('Temporary suspension')" 
                                class="text-left p-2 border border-gray-300 rounded hover:bg-gray-50 text-sm">
                            Temporary suspension
                        </button>
                        <button type="button" onclick="setReason('Investigation pending')" 
                                class="text-left p-2 border border-gray-300 rounded hover:bg-gray-50 text-sm">
                            Investigation pending
                        </button>
                        <button type="button" onclick="setReason('Administrative decision')" 
                                class="text-left p-2 border border-gray-300 rounded hover:bg-gray-50 text-sm">
                            Administrative decision
                        </button>
                    </div>
                </div>

                <!-- Confirmation -->
                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" id="confirm_block" required
                               class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                        <span class="ml-2 text-sm text-gray-700">
                            I understand that this will immediately block {{ $employee->name }} from accessing the system
                        </span>
                    </label>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('admin.employees.index') }}" 
                       class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="bg-red-600 text-white px-6 py-2 rounded-md hover:bg-red-700 transition-colors"
                            onclick="return confirm('Are you sure you want to block {{ $employee->name }}?')">
                        🚫 Block User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function setReason(reason) {
    document.getElementById('block_reason').value = reason;
}
</script>
@endsection