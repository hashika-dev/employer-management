<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Mail\AccountUnlockOtp;
use Carbon\Carbon;

class AccountReactivationController extends Controller
{
    // 1. Send OTP
    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $user = User::where('email', $request->email)->first();

        // Generate OTP
        $otp = rand(100000, 999999);
        
        $user->update([
            'unlock_otp' => Hash::make($otp), // Hash it for security
            'unlock_otp_expires_at' => Carbon::now()->addMinutes(2),
        ]);

        Mail::to($user->email)->send(new AccountUnlockOtp($otp));

        return response()->json(['message' => 'OTP sent successfully.']);
    }

    // 2. Unlock Account & Reset Password
   public function unlock(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|digits:6',
            'password' => [
                'required', 'confirmed', 'min:8',
                'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[_]/', 'regex:/^[a-zA-Z0-9_]+$/'
            ],
        ]);

        $user = User::where('email', $request->email)->first();

        // 1. Verify OTP and Expiration (Keep existing logic)
        if (!$user->unlock_otp || !Hash::check($request->otp, $user->unlock_otp)) {
            return back()->withErrors(['otp' => 'Invalid OTP code.']);
        }
        if (Carbon::now()->greaterThan($user->unlock_otp_expires_at)) {
            return back()->withErrors(['otp' => 'OTP has expired. Please request a new one.']);
        }

        // 2. UNLOCK & UPDATE
        $user->update([
            'password' => Hash::make($request->password),
            'is_locked' => 0,
            'unlock_otp' => null,
            'unlock_otp_expires_at' => null,
        ]);
        
        // 3. ROLE-BASED REDIRECTION FIX
        // Check if the user is an admin and redirect to the specific admin login page.
        if ($user->role === 'admin') {
            // NOTE: Replace 'admin.login' with your actual named admin login route if it's different.
            return redirect()->route('admin.login')->with('status', 'Account unlocked! Please login with your new password.');
        }

        // Default redirect for all other roles (Employee Login)
        return redirect()->route('login')->with('status', 'Account unlocked! Please login with your new password.');
    }
}