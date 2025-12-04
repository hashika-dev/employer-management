<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeApiController extends Controller
{
    // 1. GET (Retrieve all employees)
    public function index()
    {
        $employees = Employee::all();
        return response()->json([
            'status' => 200,
            'count' => $employees->count(),
            'data' => $employees
        ], 200);
    }

    // 2. POST (Create a new employee)
    public function store(Request $request)
    {
        // Simple validation
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:employees',
        ]);

        $employee = Employee::create($request->all());

        return response()->json([
            'status' => 201, // 201 means "Created"
            'message' => 'Employee created successfully',
            'data' => $employee
        ], 201);
    }

    // 3. GET (Retrieve ONE specific employee by ID)
    public function show($id)
    {
        $employee = Employee::find($id);

        if($employee) {
            return response()->json(['status' => 200, 'data' => $employee], 200);
        } else {
            return response()->json(['status' => 404, 'message' => 'Employee not found'], 404);
        }
    }

    // 4. PUT/PATCH (Update an employee)
    public function update(Request $request, $id)
    {
        $employee = Employee::find($id);

        if($employee) {
            $employee->update($request->all());
            return response()->json([
                'status' => 200, 
                'message' => 'Employee updated successfully',
                'data' => $employee
            ], 200);
        } else {
            return response()->json(['status' => 404, 'message' => 'Employee not found'], 404);
        }
    }

    // 5. DELETE (Remove an employee)
    public function destroy($id)
    {
        $employee = Employee::find($id);

        if($employee) {
            $employee->delete();
            return response()->json(['status' => 200, 'message' => 'Employee deleted successfully'], 200);
        } else {
            return response()->json(['status' => 404, 'message' => 'Employee not found'], 404);
        }
    }
}