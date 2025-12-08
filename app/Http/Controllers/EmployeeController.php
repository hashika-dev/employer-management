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
        // CHANGE THIS: Search first or last name instead of 'name'
        $q->where('first_name', 'like', "%{$search}%")
          ->orWhere('last_name', 'like', "%{$search}%")
          ->orWhere('email', 'like', "%{$search}%")
          ->orWhere('employee_number', 'like', "%{$search}%");
    });
}

        // Sort Logic
        if ($request->filled('sort')) {
    switch ($request->sort) {
        // CHANGE THIS: Sort by first_name instead of 'name'
        case 'name_asc': $query->orderBy('first_name', 'asc'); break;
        case 'name_desc': $query->orderBy('first_name', 'desc'); break;
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
   // In App\Http\Controllers\UserController.php

public function create()
    {
        // 1. Find the last employee with an ID starting with "EMP-"
        $lastEmployee = User::where('employee_number', 'like', 'EMP-%')
                            ->orderByRaw('LENGTH(employee_number) desc') 
                            ->orderBy('employee_number', 'desc')
                            ->first();

        // 2. Calculate the next number
        if ($lastEmployee) {
            $lastNumber = intval(substr($lastEmployee->employee_number, 4));
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        // 3. Format it (e.g., "EMP-011")
        $newEmployeeId = 'EMP-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

      $departments = Department::all();

    // FIXED: Point to 'admin.employees.create'
    return view('admin.employees.create', compact('departments', 'newEmployeeId'));
    }
    // 3. Store (Hire) Logic
   public function store(Request $request)
{
    // 1. Validate ONLY what the Admin inputs
    $request->validate([
        'email' => ['required', 'email', 'unique:users'],
        'employee_number' => ['required', 'string', 'unique:users'],
        'department_id' => ['nullable', 'exists:departments,id'],
        'job_title' => ['nullable', 'string'],
    ]);

    // 2. Generate Password (if not provided)
    $rawPassword = $request->password ?? Str::random(8);

    // 3. Create User (WITHOUT NAMES)
    $user = User::create([
        // We leave first_name/last_name NULL. The employee will fill them later.
        'email' => $request->email,
        'employee_number' => $request->employee_number,
        'password' => Hash::make($rawPassword),
        'department_id' => $request->department_id,
        'job_title' => $request->job_title,
        'role' => 'user',
        'is_setup' => 0, // Mark as 0 so you know they need to finish setup
    ]);

    // 4. Send Email (Use a generic name)
    $emailData = [
        'email' => $request->email,
        'employee_number' => $request->employee_number,
        'password' => $rawPassword,
        'name' => 'New Staff Member', // Generic greeting since we don't have a name
    ];

    Mail::to($user->email)->send(new AccountCreated($emailData));

    return redirect()->route('admin.employees.index')
                     ->with('success', 'Account created! The employee can now log in and set their name.');
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
    $employee = User::findOrFail($id);

    // 1. Validate separate name fields
    $request->validate([
        'first_name' => ['required', 'string', 'max:255'],
        'middle_initial' => ['nullable', 'string', 'max:5'],
        'last_name' => ['required', 'string', 'max:255'],
        'suffix_name' => ['nullable', 'string', 'max:10'],
        
        // Ignore the current user's email/id during unique check
        'email' => ['required', 'email', 'unique:users,email,'.$employee->id],
        'employee_number' => ['required', 'string', 'unique:users,employee_number,'.$employee->id],
        'department_id' => ['nullable', 'exists:departments,id'],
        'job_title' => ['nullable', 'string'],
    ]);

    // 2. Update the user
   $employee->update([
        'first_name' => $request->first_name,
        'middle_initial' => $request->middle_initial,
        'last_name' => $request->last_name,
        'suffix_name' => $request->suffix_name,
        'email' => $request->email,
        'department_id' => $request->department_id,
        'job_title' => $request->job_title,
        'phone' => $request->phone,
        'birthday' => $request->birthday,
        'marital_status' => $request->marital_status,
        'address' => $request->address,
        'emergency_name' => $request->emergency_name,
        'emergency_relation' => $request->emergency_relation,
        'emergency_phone' => $request->emergency_phone,
        'gender' => $request->gender,

        // ADD THIS LINE HERE:
        // UPDATE BOTH OF THESE:
        'is_setup' => 1, 
        'profile_completed' => 1, 
    ]);

    return redirect()->route('admin.employees.index')->with('success', 'Employee details updated.');
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