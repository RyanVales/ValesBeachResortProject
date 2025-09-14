<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $query = Room::with('roomType');

        // Filter by room type
        if ($request->filled('room_type_id')) {
            $query->where('room_type_id', $request->room_type_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by room number
        if ($request->filled('search')) {
            $query->where('room_number', 'LIKE', '%' . $request->search . '%');
        }

        $rooms = $query->orderBy('room_number')->paginate(20);
        
        $roomTypes = RoomType::where('is_active', true)->get();

        return view('admin.rooms.index', compact('rooms', 'roomTypes'));
    }

    public function create()
    {
        $roomTypes = RoomType::where('is_active', true)->get();
        return view('admin.rooms.create', compact('roomTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_number' => 'required|string|unique:rooms,room_number',
            'room_type_id' => 'required|exists:room_types,id',
            'floor' => 'nullable|string|max:50',
            'status' => 'required|in:available,occupied,maintenance,out_of_order',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

          // AUTO-LOGIC: If status is not "available", automatically set as inactive
    if ($validated['status'] !== 'available') {
        $validated['is_active'] = false;
    } else {
        $validated['is_active'] = $request->has('is_active');
    }

        Room::create($validated);

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Room created successfully!');
    }

    public function show(Room $room)
    {
        $room->load('roomType');
        return view('admin.rooms.show', compact('room'));
    }

    public function edit(Room $room)
    {
        $roomTypes = RoomType::where('is_active', true)->get();
        return view('admin.rooms.edit', compact('room', 'roomTypes'));
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'room_number' => 'required|string|unique:rooms,room_number,' . $room->id,
            'room_type_id' => 'required|exists:room_types,id',
            'floor' => 'nullable|string|max:50',
            'status' => 'required|in:available,occupied,maintenance,out_of_order',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

         // AUTO-LOGIC: If status is not "available", automatically set as inactive
    if ($validated['status'] !== 'available') {
        $validated['is_active'] = false;
    } else {
        $validated['is_active'] = $request->has('is_active');
    }

        $room->update($validated);

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Room updated successfully!');
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('admin.rooms.index')
            ->with('success', 'Room deleted successfully!');
    }

    public function updateStatus(Request $request, Room $room)
    {
        $validated = $request->validate([
            'status' => 'required|in:available,occupied,maintenance,out_of_order'
        ]);

        // AUTO-LOGIC: If changing status to non-available, automatically set as inactive
    $updateData = ['status' => $validated['status']];
    
    if ($validated['status'] !== 'available') {
        $updateData['is_active'] = false;
    }
    
        $room->update(['status' => $validated['status']]);

        return redirect()->back()->with('success', 'Room status updated successfully!');
    }
}