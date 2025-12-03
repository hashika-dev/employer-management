<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use App\Models\Department; // Don't forget this!
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use App\Mail\AccountCreated;

class EmployeeController extends Controller
{
    // 1. Show List
    public function index(Request $request)
    {
        $query = Employee::query();

        // Search Logic
        if ($request->filled('search')) {
            $search = $request->search;
            $userIdEmails = User::where('employee_number', 'like', "%{$search}%")->pluck('email')->toArray();

            $query->where(function($q) use ($search, $userIdEmails) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('job_title', 'like', "%{$search}%");
                
                if (!empty($userIdEmails)) {
                    $q->orWhereIn('email', $userIdEmails);
                }
            });
        }

        // Sort Logic
        if ($request->filled('sort')) {
            switch ($request->sort) {
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

        $employees = $query->get();
        return view('admin.employees.index', compact('employees'));
    }

    // 2. Show Hire Form
    public function create()
    {
        $departments = Department::all();
        return view('admin.employees.create', compact('departments'));
    }

    // 3. Store (Hire) Logic - UPDATED (Removed Gender)
    public function store(Request $request)
    {
        $request->validate([
            'email'           => 'required|email|unique:users,email|unique:employees,email',
            'employee_number' => 'required|string|unique:users,employee_number',
            'password'        => 'required|string|min:6',
            'job_title'       => 'required|string|max:255',
            'department_id'   => 'nullable|exists:departments,id',
            // Removed 'gender' validation here
        ]);

        // Create Employee Record
        Employee::create([
            'first_name'    => 'Pending',
            'last_name'     => 'Update',
            'job_title'     => $request->job_title,
            'email'         => $request->email,
            'department_id' => $request->department_id,
            // Removed 'gender' saving here. It stays NULL until user updates it.
        ]);

        // Create User Account
        $user = User::create([
            'name'            => $request->employee_number,
            'email'           => $request->email,
            'employee_number' => $request->employee_number,
            'password'        => Hash::make($request->password),
            'profile_completed' => false,
            
            // --- ADD THIS LINE ---
            'email_verified_at' => now(), // <--- Marks email as verified immediately
            // ---------------------
        ]);

        // Send Email
        try {
            Config::set('mail.default', 'smtp');
            Config::set('mail.mailers.smtp.host', 'smtp.gmail.com');
            Config::set('mail.mailers.smtp.port', 587);
            Config::set('mail.mailers.smtp.encryption', 'tls');
            Config::set('mail.mailers.smtp.username', env('MAIL_USERNAME'));
            Config::set('mail.mailers.smtp.password', env('MAIL_PASSWORD'));
            Config::set('mail.from.address', env('MAIL_FROM_ADDRESS'));
            Config::set('mail.from.name', 'StaffFlow Admin');

            Mail::to($user->email)->sendNow(new AccountCreated($user, $request->password));

        } catch (\Exception $e) {
            return redirect()->route('admin.employees.index')
                ->with('warning', 'User created, but email failed: ' . $e->getMessage());
        }

        return redirect()->route('admin.employees.index')
                        ->with('success', 'User created! They can login with ID: ' . $request->employee_number);
    }

    // 4. Show Details
    public function show($id)
    {
        $employee = Employee::findOrFail($id);
        $user = User::where('email', $employee->email)->first();
        return view('admin.employees.show', compact('employee', 'user'));
    }

    // 5. Edit Form
    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        $departments = Department::all();
        return view('admin.employees.edit', compact('employee', 'departments'));
    }

    // 6. Update Employee
    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $employee->update($request->all()); // Admin can still edit gender here if they want
        return redirect()->route('admin.employees.index')->with('success', 'Updated!');
    }

    // 7. Delete (Employee + User)
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $user = User::where('email', $employee->email)->first();
        if ($user) {
            $user->delete();
        }
        $employee->delete();

        return redirect()->route('admin.employees.index')->with('success', 'Deleted!');
    }

    // 8. Archive (Ban) User
    public function archive($id)
    {
        $employee = Employee::findOrFail($id);
        $user = User::where('email', $employee->email)->first();

        if ($user) {
            if ($user->archived_at) {
                $user->update(['archived_at' => null]);
                $message = 'User account restored.';
            } else {
                $user->update(['archived_at' => now()]);
                $message = 'User account archived.';
            }
        } else {
            return back()->with('error', 'No user login found.');
        }

        return back()->with('success', $message);
    }
}