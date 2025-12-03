<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Department;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // 1. Basic Counts
        $totalEmployees = Employee::count();
        $totalDepartments = Department::count();

        // 2. Gender Stats (For Pie Chart)
        // If a filter is applied, we only count gender for THAT department
        $genderQuery = Employee::select('gender', DB::raw('count(*) as count'))
            ->groupBy('gender');

        if ($request->has('filter_dept') && $request->filter_dept != '') {
            $genderQuery->where('department_id', $request->filter_dept);
        }

        $genderStats = $genderQuery->pluck('count', 'gender');
        $genderLabels = $genderStats->keys(); // ['Male', 'Female']
        $genderData = $genderStats->values(); // [10, 5]

        // 3. Department Stats (For Bar Chart)
        // Count how many employees are in each department
        $deptStats = Department::withCount('employees')->get();
        $deptLabels = $deptStats->pluck('name');
        $deptData = $deptStats->pluck('employees_count');

        // 4. Pass Data to View
        $allDepartments = Department::all(); // For the dropdown menu

        return view('admin-dashboard', compact(
            'totalEmployees', 
            'totalDepartments',
            'genderLabels', 
            'genderData', 
            'deptLabels', 
            'deptData',
            'allDepartments'
        ));
    }
}