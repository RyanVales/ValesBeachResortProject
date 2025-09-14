<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * Display a listing of employees with filters.
     /**
 * Display a listing of employees with filters.
 */
public function index(Request $request): View
{
    $query = User::query();

    // Filter by status (active/blocked) - NEW ADDITION
    if ($request->filled('status')) {
        if ($request->status === 'active') {
            $query->where('is_blocked', false);
        } elseif ($request->status === 'blocked') {
            $query->where('is_blocked', true);
        }
    }

    // Exclude admin users from employee list (optional)
    if ($request->filled('include_admin') && $request->include_admin == '0') {
        $query->where('role', '!=', 'admin');
    }

    // Filter by role
    if ($request->filled('role')) {
        $query->where('role', $request->role);
    }

    // Filter by name
    if ($request->filled('name')) {
        $query->where('name', 'like', '%' . $request->name . '%');
    }

    // Filter by email
    if ($request->filled('email')) {
        $query->where('email', 'like', '%' . $request->email . '%');
    }

    // Sort options
    $sortBy = $request->get('sort_by', 'created_at');
    $sortOrder = $request->get('sort_order', 'desc');
    
    if (in_array($sortBy, ['name', 'email', 'role', 'created_at'])) {
        $query->orderBy($sortBy, $sortOrder);
    }

    $employees = $query->paginate(15);

    // Get role statistics
    $roleStats = User::selectRaw('role, COUNT(*) as count')
        ->groupBy('role')
        ->pluck('count', 'role')
        ->toArray();

    return view('admin.employees.index', compact('employees', 'roleStats'));
}
    public function create(): View
    {
        return view('admin.employees.create');
    }

    /**
     * Store a newly created employee.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,staff,manager,receptionist,housekeeper,maintenance',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['email_verified_at'] = now();

        User::create($validated);

        return redirect()->route('admin.employees.index')->with('success', 'Employee created successfully!');
    }

    /**
     * Display the specified employee.
     */
    public function show(User $employee): View
    {
        return view('admin.employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified employee.
     */
    public function edit(User $employee): View
    {
        return view('admin.employees.edit', compact('employee'));
    }

    /**
     * Update the specified employee.
     */
    public function update(Request $request, User $employee)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $employee->id,
            'role' => 'required|in:admin,staff,manager,receptionist,housekeeper,maintenance',
        ]);

        // Only update password if provided
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);
            $validated['password'] = Hash::make($request->password);
        }

        $employee->update($validated);

        return redirect()->route('admin.employees.index')->with('success', 'Employee updated successfully!');
    }

    /**
     * Remove the specified employee.
     */
    public function destroy(User $employee)
    {
        // Prevent deleting the current user
        if ($employee->id === auth()->id()) {
            return redirect()->route('admin.employees.index')->with('error', 'You cannot delete your own account!');
        }

        $employee->delete();
        return redirect()->route('admin.employees.index')->with('success', 'Employee deleted successfully!');
    }
    /**
     * Block a user account
     */
    public function block(Request $request, User $employee)
    {
        // Prevent blocking yourself
        if ($employee->id === auth()->id()) {
            return redirect()->route('admin.employees.index')
                ->with('error', 'You cannot block your own account!');
        }

        // Prevent blocking other admins (optional)
        if ($employee->role === 'admin' && auth()->user()->role !== 'admin') {
            return redirect()->route('admin.employees.index')
                ->with('error', 'You cannot block an admin account!');
        }

        $validated = $request->validate([
            'block_reason' => 'nullable|string|max:500',
        ]);

        $employee->block($validated['block_reason'] ?? 'Blocked by administrator');

        return redirect()->route('admin.employees.index')
            ->with('success', "User {$employee->name} has been blocked successfully!");
    }

    /**
     * Unblock a user account
     */
    public function unblock(User $employee)
    {
        $employee->unblock();

        return redirect()->route('admin.employees.index')
            ->with('success', "User {$employee->name} has been unblocked successfully!");
    }

    /**
     * Show block form
     */
    public function showBlockForm(User $employee): View
    {
        // Prevent blocking yourself
        if ($employee->id === auth()->id()) {
            abort(403, 'You cannot block your own account');
        }

        return view('admin.employees.block', compact('employee'));
    }
}