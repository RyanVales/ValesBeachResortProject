<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Welcome to Vales Beach Resort') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Welcome, {{ auth()->user()->name }}!</h3>
                    <p class="mb-4">Thank you for registering with Vales Beach Resort. As a valued customer, you can:</p>
                    
                    <ul class="list-disc list-inside space-y-2 mb-6">
                        <li>Browse our resort amenities</li>
                        <li>Make booking inquiries</li>
                        <li>Update your profile information</li>
                        <li>Contact our staff for assistance</li>
                    </ul>

                    <div class="space-x-4">
                        <a href="{{ route('profile.edit') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Edit Profile
                        </a>
                        <a href="#" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Contact Us
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>