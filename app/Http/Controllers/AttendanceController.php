<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    // --- USER SIDE ---

    public function timeIn()
    {
        $user = Auth::user();
        $today = Carbon::today();

        // Check if already timed in today
        $attendance = Attendance::where('user_id', $user->id)->where('date', $today)->first();

        if ($attendance) {
            return back()->with('error', 'You have already timed in today!');
        }

        Attendance::create([
            'user_id' => $user->id,
            'date' => $today,
            'time_in' => Carbon::now()->format('H:i:s'),
        ]);

        return back()->with('success', 'Time In Recorded: ' . Carbon::now()->format('h:i A'));
    }

    public function timeOut()
    {
        $user = Auth::user();
        $today = Carbon::today();

        // Find today's record
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

        return back()->with('success', 'Time Out Recorded: ' . Carbon::now()->format('h:i A'));
    }

    // --- ADMIN SIDE ---

    public function index()
    {
        // Get all attendance records, ordered by latest date
        $attendances = Attendance::with('user')->orderBy('date', 'desc')->orderBy('time_in', 'desc')->get();
        return view('admin.attendance.index', compact('attendances'));
    }
}