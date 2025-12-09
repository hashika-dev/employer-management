<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules; // Import standard Password rules
use App\Mail\AccountUnlockOtp;
use Carbon\Carbon;

class AccountReactivationController extends Controller
{
    // 1. Send OTP
    public function sendOtp(Request $request)
    {
        // Allow looking up by email OR employee_number to find the email
        $input = $request->email;
        $user = User::where('email', $input)->orWhere('employee_number', $input)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        // Generate OTP
        $otp = rand(100000, 999999);
        
        $user->update([
            'unlock_otp' => Hash::make($otp),
            'unlock_otp_expires_at' => Carbon::now()->addMinutes(2),
        ]);

        // Always send to the registered email
        Mail::to($user->email)->send(new AccountUnlockOtp($otp));

        return response()->json(['message' => 'OTP sent successfully.']);
    }

    // 2. Unlock Account & Reset Password
    public function unlock(Request $request)
    {
        // 1. Validate Input
        $request->validate([
            'email' => 'required', // Can be email or ID
            'otp' => 'required|digits:6',
            'password' => ['required', 'confirmed', Rules\Password::defaults()], // Use Laravel's default safe rules
        ]);

        // Find user by Email OR Employee ID
        $user = User::where('email', $request->email)
                    ->orWhere('employee_number', $request->email)
                    ->first();

        if (!$user) {
            return back()->withErrors(['email' => 'User not found.']);
        }

        // 2. Verify OTP
        if (!$user->unlock_otp || !Hash::check($request->otp, $user->unlock_otp)) {
            return back()->withErrors(['otp' => 'Invalid OTP code.']);
        }
        if (Carbon::now()->greaterThan($user->unlock_otp_expires_at)) {
            return back()->withErrors(['otp' => 'OTP has expired. Please request a new one.']);
        }

        // 3. UNLOCK & UPDATE
        $user->update([
            'password' => Hash::make($request->password),
            'is_locked' => 0, // IMPORTANT: Unlock the DB flag
            'unlock_otp' => null,
            'unlock_otp_expires_at' => null,
        ]);

        // 4. CLEAR RATE LIMITER (Crucial Fix)
        // We must clear BOTH the Email key and the Employee ID key to be safe
        
        // Key 1: Email
        $keyEmail = Str::transliterate(Str::lower($user->email).'|'.$request->ip());
        RateLimiter::clear($keyEmail);

        // Key 2: Employee Number (if it exists)
        if ($user->employee_number) {
            $keyID = Str::transliterate(Str::lower($user->employee_number).'|'.$request->ip());
            RateLimiter::clear($keyID);
        }

        // 5. REDIRECT
        $redirectRoute = ($user->role === 'admin') ? 'admin.login' : 'login';
        
        return redirect()->route($redirectRoute)
                         ->with('status', 'Account unlocked successfully! You can now log in with your new password.');
    }
}