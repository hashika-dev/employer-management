<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\TwoFactorCode;

class TwoFactorController extends Controller
{
    // 1. Show the "Enter Code" page
    public function index()
    {
        return view('auth.verify');
    }

    // 2. Verify the code (When user clicks Submit)
    public function store(Request $request)
    {
        $request->validate([
            'two_factor_code' => 'required|integer',
        ]);

        $user = auth()->user();

        // Check if code matches AND is valid
        if ($request->two_factor_code == $user->two_factor_code) {
            
            // Success! Clear the code so they don't get asked again
            $user->resetCode();

            // Redirect to the Admin Dashboard
            return redirect()->route('admin.dashboard');
        }

        // Failure: Go back with error
        return back()->withErrors(['two_factor_code' => 'The code is invalid or wrong.']);
    }

    // 3. Resend the Email
    public function resend()
    {
        $user = auth()->user();
        $user->generateCode(); // Make a new number
        
        try {
            Mail::to($user->email)->send(new TwoFactorCode($user->two_factor_code));
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Could not send email.']);
        }
        
        return back()->with('message', 'A new code has been sent to your email.');
    }
}