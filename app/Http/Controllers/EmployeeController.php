<?php

namespace App\Http\Controllers;

use App\Models\User; // We only use User now
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use App\Mail\AccountCreated;

class EmployeeController extends Controller
{
    // 1. Show List (Users Only)
    public function index(Request $request)
    {
        // Start query on User model
        // FIX: Added filter to exclude admins immediately
        $query = User::where('role', '!=', 'admin');

        // Optional: Hide yourself (the currently logged in admin) specifically
        // $query->where('id', '!=', auth()->id()); 

        // Search Logic
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('employee_number', 'like', "%{$search}%")
                  ->orWhere('job_title', 'like', "%{$search}%");
            });
        }

        // Sort Logic
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'name_asc': $query->orderBy('name', 'asc'); break;
                case 'name_desc': $query->orderBy('name', 'desc'); break;
                case 'date_newest': $query->orderBy('created_at', 'desc'); break;
                case 'date_oldest': $query->orderBy('created_at', 'asc'); break;
                case 'job': $query->orderBy('job_title', 'asc'); break;
                default: $query->orderBy('created_at', 'desc');
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $employees = $query->paginate(10); // Added pagination for better UI
        return view('admin.employees.index', compact('employees'));
    }

    // 2. Show Hire Form
    public function create()
    {
        $departments = Department::all();

        // --- AUTO-INCREMENT LOGIC ---
        $lastUser = User::whereRaw('employee_number REGEXP "^[0-9]+$"')
                        ->orderByRaw('CAST(employee_number AS UNSIGNED) DESC')
                        ->first();

        // 2. Calculate the next number
        if ($lastUser) {
            $nextNum = intval($lastUser->employee_number) + 1;
        } else {
            $nextNum = 1; // Start at 1 if no employees exist
        }

        // 3. Format it (e.g., '001', '025', '100')
        $suggestedID = str_pad($nextNum, 3, '0', STR_PAD_LEFT);

        return view('admin.employees.create', compact('departments', 'suggestedID'));
    }

    // 3. Store (Hire) Logic
    public function store(Request $request)
    {
        // 1. Validate (REMOVED 'name' from validation)
        $request->validate([
            'email'           => 'required|email|unique:users,email',
            'employee_number' => 'required|string|unique:users,employee_number',
            'password'        => 'required|string|min:6',
            'job_title'       => 'required|string|max:255',
            'department_id'   => 'nullable|exists:departments,id',
        ]);

        // 2. Create the User
        $user = User::create([
            'name'            => $request->employee_number, // <--- Name defaults to ID (e.g. "025")
            'email'           => $request->email,
            'employee_number' => $request->employee_number,
            'password'        => Hash::make($request->password),
            'job_title'       => $request->job_title,
            'department_id'   => $request->department_id,
            'role'            => 'user',
            'profile_completed' => false,
            'is_setup'          => true,
            'email_verified_at' => now(),
        ]);

        // 3. Send Email
        try {
             \Illuminate\Support\Facades\Config::set('mail.default', 'smtp');
            \Illuminate\Support\Facades\Mail::to($user->email)->send(new AccountCreated($user, $request->password));

        } catch (\Exception $e) {
            return redirect()->route('admin.employees.index')
                ->with('warning', 'User created, but email failed: ' . $e->getMessage());
        }

        return redirect()->route('admin.employees.index')
                        ->with('success', 'New staff member added! Name set to ID: ' . $request->employee_number);
    }

    // 4. Show Details
    public function show($id)
    {
        // Find the User directly
        $employee = User::findOrFail($id); 
        // Pass it as 'employee' so you don't have to change your View variable names
        return view('admin.employees.show', compact('employee'));
    }

    // 5. Edit Form
    public function edit($id)
    {
        $employee = User::findOrFail($id);
        $departments = Department::all();
        return view('admin.employees.edit', compact('employee', 'departments'));
    }

    // 6. Update Employee
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        // We can update everything at once now
        $user->update($request->only([
            'job_title', 
            'department_id', 
            'employee_number', 
            'email',
            // Add other fields here if your edit form includes them
        ]));

        return redirect()->route('admin.employees.index')->with('success', 'Employee details updated!');
    }

    // 7. Delete (User Only)
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.employees.index')->with('success', 'Employee deleted!');
    }

    // 8. Archive (Ban) User
    public function archive($id)
    {
        $user = User::findOrFail($id);

        if ($user->archived_at) {
            $user->update(['archived_at' => null]);
            $message = 'User account restored.';
        } else {
            $user->update(['archived_at' => now()]);
            $message = 'User account archived.';
        }

        return back()->with('success', $message);
    }
}