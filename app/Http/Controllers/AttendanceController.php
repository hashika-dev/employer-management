<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    // --- USER SIDE (Keep Unchanged) ---
    public function timeIn()
    {
        $user = Auth::user();
        $today = Carbon::today();

        $attendance = Attendance::where('user_id', $user->id)->where('date', $today)->first();

        if ($attendance) {
            return back()->with('error', 'You have already timed in today!');
        }

        Attendance::create([
            'user_id' => $user->id,
            'date' => $today,
            'time_in' => Carbon::now()->format('H:i:s'),
        ]);

        return back()->with('success', 'Time In Recorded');
    }

    public function timeOut()
    {
        $user = Auth::user();
        $today = Carbon::today();

        $attendance = Attendance::where('user_id', $user->id)->where('date', $today)->first();

        if (!$attendance) {
            return back()->with('error', 'You have not timed in yet!');
        }

        if ($attendance->time_out) {
            return back()->with('error', 'You have already timed out today!');
        }

        $attendance->update([
            'time_out' => Carbon::now()->format('H:i:s'),
        ]);

        return back()->with('success', 'Time Out Recorded');
    }

    // --- ADMIN SIDE (UPDATED) ---

    /**
     * Step 1: Display list of employees to choose from
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Optional: Filter the list of users by name
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('employee_number', 'like', '%' . $request->search . '%');
        }

        // Exclude generic admins if necessary, or just show everyone
        // $query->where('usertype', 'user'); 

        $employees = $query->paginate(15);

        return view('admin.attendance.index', compact('employees'));
    }

    /**
     * Step 2: Display history for a SPECIFIC employee
     */
    public function show(Request $request, $user_id)
    {
        $employee = User::findOrFail($user_id);

        // Filters
        $month = $request->get('month', date('m'));
        $year = $request->get('year', date('Y'));

        // Query Logic
        $attendanceQuery = Attendance::where('user_id', $user_id)
            ->whereMonth('date', $month)
            ->whereYear('date', $year);

        // Sorting
        $sort = $request->get('sort', 'date');
        $direction = $request->get('direction', 'desc');
        $attendanceQuery->orderBy($sort, $direction);

        $attendances = $attendanceQuery->get();

        // Calculate Stats for this month
        $daysPresent = $attendances->count();
        $lates = 0;
        foreach($attendances as $att) {
            $timeIn = Carbon::parse($att->time_in);
            if ($timeIn->gt(Carbon::parse('09:00:00'))) {
                $lates++;
            }
        }

        return view('admin.attendance.show', compact('employee', 'attendances', 'month', 'year', 'daysPresent', 'lates'));
    }
}