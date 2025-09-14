<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GuestController extends Controller
{
    public function index(Request $request)
    {
        $query = Guest::query();

        // Search functionality
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by VIP status
        if ($request->filled('vip')) {
            $query->where('is_vip', $request->vip == 'yes');
        }

        // Filter by country
        if ($request->filled('country')) {
            $query->where('country', $request->country);
        }

        $guests = $query->with('bookings')
                       ->orderBy('created_at', 'desc')
                       ->paginate(15);

        // Statistics
        $stats = [
            'total' => Guest::count(),
            'active' => Guest::where('status', 'active')->count(),
            'vip' => Guest::where('is_vip', true)->count(),
            'total_stays' => Guest::sum('total_stays'),
            'total_revenue' => Guest::sum('total_spent'),
        ];

        return view('admin.guests.index', compact('guests', 'stats'));
    }

    public function create()
    {
        return view('admin.guests.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:guests,email',
            'phone' => 'nullable|string|max:20',
            'country_code' => 'nullable|string|max:5',
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female,other,prefer_not_to_say',
            'nationality' => 'nullable|string|max:100',
            'passport_number' => 'nullable|string|max:50',
            'id_type' => 'nullable|string|max:100',
            'id_number' => 'nullable|string|max:100',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state_province' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'contact_preferences' => 'nullable|array',
            'dietary_restrictions' => 'nullable|array',
            'special_requests' => 'nullable|array',
            'notes' => 'nullable|string',
            'is_vip' => 'boolean',
            'preferred_language' => 'nullable|string|max:50',
        ]);

        $guest = Guest::create($validated);

        return redirect()
            ->route('admin.guests.show', $guest)
            ->with('success', 'Guest profile created successfully!');
    }

    public function show(Guest $guest)
    {
        $guest->load(['bookings' => function ($query) {
            $query->orderBy('created_at', 'desc')->take(10);
        }]);

        return view('admin.guests.show', compact('guest'));
    }

    public function edit(Guest $guest)
    {
        return view('admin.guests.edit', compact('guest'));
    }

    public function update(Request $request, Guest $guest)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:guests,email,' . $guest->id,
            'phone' => 'nullable|string|max:20',
            'country_code' => 'nullable|string|max:5',
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female,other,prefer_not_to_say',
            'nationality' => 'nullable|string|max:100',
            'passport_number' => 'nullable|string|max:50',
            'id_type' => 'nullable|string|max:100',
            'id_number' => 'nullable|string|max:100',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state_province' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'contact_preferences' => 'nullable|array',
            'dietary_restrictions' => 'nullable|array',
            'special_requests' => 'nullable|array',
            'notes' => 'nullable|string',
            'is_vip' => 'boolean',
            'preferred_language' => 'nullable|string|max:50',
        ]);

        $guest->update($validated);

        return redirect()
            ->route('admin.guests.show', $guest)
            ->with('success', 'Guest profile updated successfully!');
    }

    public function destroy(Guest $guest)
    {
        // Check if guest has any bookings
        if ($guest->bookings()->count() > 0) {
            return redirect()
                ->route('admin.guests.index')
                ->with('error', 'Cannot delete guest with existing bookings.');
        }

        $guest->delete();

        return redirect()
            ->route('admin.guests.index')
            ->with('success', 'Guest profile deleted successfully!');
    }

    // Additional methods
    public function toggleVip(Guest $guest)
    {
        $guest->update(['is_vip' => !$guest->is_vip]);

        $status = $guest->is_vip ? 'granted' : 'removed';
        
        return redirect()
            ->back()
            ->with('success', "VIP status {$status} for {$guest->full_name}!");
    }

    public function blacklist(Request $request, Guest $guest)
    {
        $request->validate([
            'reason' => 'required|string|max:500'
        ]);

        $guest->blacklist($request->reason);

        return redirect()
            ->back()
            ->with('success', "Guest {$guest->full_name} has been blacklisted.");
    }

    public function unblacklist(Guest $guest)
    {
        $guest->unblacklist();

        return redirect()
            ->back()
            ->with('success', "Guest {$guest->full_name} has been removed from blacklist.");
    }
}