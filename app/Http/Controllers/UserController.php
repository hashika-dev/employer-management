<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // 1. Start by filtering OUT the admin
        // Note: Make sure your database role is exactly 'admin' (lowercase). 
        // If your DB uses 'Admin' or '1', change the value below.
        $query = User::with('department')->where('role', '!=', 'admin');

        if ($request->has('search') && $request->search != '') {
            // 2. CRITICAL FIX: Group the search conditions in a function.
            // This ensures logic is: (Not Admin) AND (Name matches OR Employee matches)
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('employee_number', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->paginate(10);
        return view('admin.users.index', compact('users'));
    }

      // 2. Calculate the next number

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'employee_number' => ['required', 'string', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'department_id' => ['nullable', 'exists:departments,id'],
            'job_title' => ['nullable', 'string'],
        ]);

        User::create([
           'first_name' => $request->first_name, // <-- ADD THIS
    'last_name' => $request->last_name,   // <-- ADD THIS
    'middle_initial' => $request->middle_initial, // <-- ADD THIS
            'email' => $request->email,
            'employee_number' => $request->employee_number,
            'password' => Hash::make($request->password),
            'department_id' => $request->department_id,
            'job_title' => $request->job_title,
            'role' => 'user', 
            'is_setup' => 1, 
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Staff member created successfully.');
    }

    public function edit(User $user)
    {
        $departments = Department::all();
        return view('admin.users.edit', compact('user', 'departments'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,'.$user->id],
            'department_id' => ['nullable', 'exists:departments,id'],
            'job_title' => ['nullable', 'string'],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'department_id' => $request->department_id,
            'job_title' => $request->job_title,
            // 'phone' => $request->phone, // Ensure 'phone' is in your $request if you use this
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Staff updated.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Staff member removed.');
    }
}