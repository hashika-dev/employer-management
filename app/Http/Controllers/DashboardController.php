<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;        // <--- UPDATED: Use User model
use App\Models\Department;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // 1. Basic Counts (Users who are NOT admins)
        $totalEmployees = User::where('role', '!=', 'admin')->count();
        $totalDepartments = Department::count();

        // 2. Gender Stats (For Pie Chart)
        $genderQuery = User::where('role', '!=', 'admin')
            ->select('gender', DB::raw('count(*) as count'))
            ->groupBy('gender');

        if ($request->has('filter_dept') && $request->filter_dept != '') {
            $genderQuery->where('department_id', $request->filter_dept);
        }

        $genderStats = $genderQuery->pluck('count', 'gender');
        
        // Ensure we handle empty/null gender nicely
        $genderLabels = $genderStats->keys()->map(fn($k) => $k ?: 'Not Set'); 
        $genderData = $genderStats->values();

        // 3. Department Stats (For Bar Chart)
        // We use 'users_count' because the relationship in Department model is usually 'users'
        // If your relationship is still named 'employees', keep it as 'employees_count'
        $deptStats = Department::withCount('users')->get(); 
        
        $deptLabels = $deptStats->pluck('name');
        $deptData = $deptStats->pluck('users_count'); // <--- Updated to users_count

        // 4. Pass Data to View
        $allDepartments = Department::all();

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