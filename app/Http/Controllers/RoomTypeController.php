<?php

namespace App\Http\Controllers;

use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomTypeController extends Controller
{
    public function index()
    {
        $roomTypes = RoomType::with('rooms')->paginate(10);
        
        // Calculate statistics
        $stats = [
            'total' => RoomType::count(),
            'active' => RoomType::where('is_active', true)->count(),
            'inactive' => RoomType::where('is_active', false)->count(),
            'total_rooms' => \App\Models\Room::count(),
        ];

        return view('admin.room-types.index', compact('roomTypes', 'stats'));
    }

    public function create()
    {
        return view('admin.room-types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:room_types',
            'description' => 'nullable|string',
            'capacity' => 'required|integer|min:1|max:20',
            'base_price' => 'required|numeric|min:0',
            'amenities' => 'nullable|array',
            'amenities.*' => 'string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('room-types', 'public');
        }

        // Convert amenities array to proper format
        if (!empty($validated['amenities'])) {
            $validated['amenities'] = array_filter($validated['amenities']);
        }

        $validated['is_active'] = $request->has('is_active');

        RoomType::create($validated);

        return redirect()->route('admin.room-types.index')
            ->with('success', 'Room type created successfully!');
    }

    public function show(RoomType $roomType)
    {
        $roomType->load(['rooms' => function ($query) {
            $query->with('newBookings');
        }]);

        return view('admin.room-types.show', compact('roomType'));
    }

    public function edit(RoomType $roomType)
    {
        return view('admin.room-types.edit', compact('roomType'));
    }

    public function update(Request $request, RoomType $roomType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:room_types,name,' . $roomType->id,
            'description' => 'nullable|string',
            'capacity' => 'required|integer|min:1|max:20',
            'base_price' => 'required|numeric|min:0',
            'amenities' => 'nullable|array',
            'amenities.*' => 'string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($roomType->image) {
                Storage::disk('public')->delete($roomType->image);
            }
            $validated['image'] = $request->file('image')->store('room-types', 'public');
        }

        // Convert amenities array to proper format
        if (!empty($validated['amenities'])) {
            $validated['amenities'] = array_filter($validated['amenities']);
        }

        $validated['is_active'] = $request->has('is_active');

        $roomType->update($validated);

        return redirect()->route('admin.room-types.index')
            ->with('success', 'Room type updated successfully!');
    }

    public function destroy(RoomType $roomType)
    {
        // Check if room type has rooms
        if ($roomType->rooms()->exists()) {
            return redirect()->route('admin.room-types.index')
                ->with('error', 'Cannot delete room type that has associated rooms.');
        }

        // Delete image
        if ($roomType->image) {
            Storage::disk('public')->delete($roomType->image);
        }

        $roomType->delete();

        return redirect()->route('admin.room-types.index')
            ->with('success', 'Room type deleted successfully!');
    }

    public function toggle(RoomType $roomType)
    {
        $roomType->update(['is_active' => !$roomType->is_active]);

        $status = $roomType->is_active ? 'activated' : 'deactivated';
        
        return redirect()->route('admin.room-types.index')
            ->with('success', "Room type {$status} successfully!");
    }
}