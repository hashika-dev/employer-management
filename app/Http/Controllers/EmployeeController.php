<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use App\Mail\AccountCreated;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        return view('admin.employees.index', compact('employees'));
    }

    public function create()
    {
        return view('admin.employees.create');
    }

    public function store(Request $request)
    {
        // Validate only what Admin enters (Email + ID + Pass)
        $request->validate([
            'email'           => 'required|email|unique:users,email|unique:employees,email',
            'employee_number' => 'required|string|unique:users,employee_number',
            'password'        => 'required|string|min:6',
        ]);

        // 1. Create Employee Record (Placeholder Names)
        Employee::create([
            'first_name' => 'Pending', 
            'last_name'  => 'Update',
            'job_title'  => 'New Hire',
            'email'      => $request->email,
        ]);

        // 2. Create User Account
        // Note: We save the Email here so they can use it to login later!
        $user = User::create([
            'name'            => $request->employee_number, // Temp name
            'email'           => $request->email,
            'employee_number' => $request->employee_number,
            'password'        => Hash::make($request->password),
            'role'            => 'user',
        ]);

        // 3. Force Email Send
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

    // Standard CRUD methods...
    public function edit($id) {
        $employee = Employee::findOrFail($id);
        return view('admin.employees.edit', compact('employee'));
    }

    public function update(Request $request, $id) {
        $employee = Employee::findOrFail($id);
        $employee->update($request->all());
        return redirect()->route('admin.employees.index')->with('success', 'Updated!');
    }

    // 6. Delete the employee AND their login account
    public function destroy($id)
    {
        // 1. Find the Employee Record
        $employee = Employee::findOrFail($id);

        // 2. Find the associated User Login (linked by email)
        $user = User::where('email', $employee->email)->first();

        // 3. Delete the User Login (if it exists)
        if ($user) {
            $user->delete();
        }

        // 4. Delete the Employee Record
        $employee->delete();

        return redirect()->route('admin.employees.index')
                        ->with('success', 'Employee and their Login Account removed successfully!');
    }
}