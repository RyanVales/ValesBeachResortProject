<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function index()
    {
        // Check if user is admin
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        
        $staff = User::where('role', '!=', 'admin')->orderBy('created_at', 'desc')->get();
        return view('admin.staff.index', compact('staff'));
    }

    public function create()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        
        return view('admin.staff.create');
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:manager,receptionist,housekeeper,concierge,maintenance,chef,security',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('staff.index')->with('success', 'Staff member created successfully!');
    }

    public function edit(User $user)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        if ($user->role === 'admin') {
            abort(403, 'Cannot edit admin users.');
        }

        return view('admin.staff.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        if ($user->role === 'admin') {
            abort(403, 'Cannot edit admin users.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:manager,receptionist,housekeeper,concierge,maintenance,chef,security',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return redirect()->route('staff.index')->with('success', 'Staff member updated successfully!');
    }

    public function destroy(User $user)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        if ($user->role === 'admin') {
            abort(403, 'Cannot delete admin users.');
        }

        $user->delete();

        return redirect()->route('staff.index')->with('success', 'Staff member deleted successfully!');
    }
}