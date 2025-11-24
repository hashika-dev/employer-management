<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    // 1. Show the list of employees
    public function index()
    {
        $employees = Employee::all(); // Fetch everyone from DB
        return view('admin.employees.index', compact('employees'));
    }

    // 2. Show the "Hire New" form
    public function create()
    {
        return view('admin.employees.create');
    }

    // 3. Save the new employee to the database
    public function store(Request $request)
    {
        // Validate inputs
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'job_title' => 'required',
            'email' => 'nullable|email',
        ]);

        // Save
        Employee::create($request->all());

        // Redirect back with success message
        return redirect()->route('admin.employees.index')
                        ->with('success', 'New employee hired successfully!');
    }
    // 4. Show the Edit Form (Pre-filled with data)
    public function edit($id)
    {
        $employee = Employee::findOrFail($id); // Find employee or show 404 error
        return view('admin.employees.edit', compact('employee'));
    }

    // 5. Update the data in the Database
    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'job_title' => 'required',
            'email' => 'nullable|email',
        ]);

        $employee = Employee::findOrFail($id);
        $employee->update($request->all()); // Save changes

        return redirect()->route('admin.employees.index')
                        ->with('success', 'Employee updated successfully!');
    }

    // 6. Delete the employee
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return redirect()->route('admin.employees.index')
                        ->with('success', 'Employee removed successfully!');
    }
}