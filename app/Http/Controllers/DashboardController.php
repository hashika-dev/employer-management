<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Get Total Count
        $totalEmployees = Employee::count();

        // 2. Get Data for the Graph (Group by Job Title)
        // This calculates: "Engineer" => 3, "Manager" => 1, etc.
        $employeesByJob = Employee::select('job_title')
            ->selectRaw('count(*) as count')
            ->groupBy('job_title')
            ->get();

        // 3. Prepare data for Chart.js (It needs two separate arrays)
        $labels = $employeesByJob->pluck('job_title'); // List of names: ['Engineer', 'HR']
        $data = $employeesByJob->pluck('count');       // List of numbers: [5, 2]

        return view('admin-dashboard', compact('totalEmployees', 'labels', 'data'));
    }
}