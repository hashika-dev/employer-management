<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeApiController extends Controller
{
    // 1. GET /api/employees
    // Returns a list of all employees in JSON format
    public function index()
    {
        $employees = Employee::all();

        return response()->json([
            'status' => 200,
            'message' => 'Here are all the employees',
            'data' => $employees
        ]);
    }

    // 2. GET /api/employees/{id}
    // Returns ONE specific employee
    public function show($id)
    {
        $employee = Employee::find($id);

        if ($employee) {
            return response()->json([
                'status' => 200,
                'data' => $employee
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Employee not found'
            ], 404);
        }
    }
}