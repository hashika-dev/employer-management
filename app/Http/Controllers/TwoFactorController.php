<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\TwoFactorCode;

class TwoFactorController extends Controller
{
    public function index()
    {
        return view('auth.verify');
    }

    public function store(Request $request)
    {
        $request->validate([
            'two_factor_code' => 'required|integer',
        ]);

        $user = auth()->user();

        // Check if code matches
        if ($request->two_factor_code == $user->two_factor_code) {
            
            $user->resetCode(); // Clear the code

            // --- SMART REDIRECT ---
            // If Admin -> Go to Admin Dashboard
            // If Employee -> Go to User Dashboard
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('dashboard');
            }
        }

        return back()->withErrors(['two_factor_code' => 'The code is invalid or wrong.']);
    }

   public function resend()
    {
        $user = auth()->user();
        $user->generateCode();
        
        try {
            Mail::to($user->email)->send(new TwoFactorCode($user->two_factor_code));
        } catch (\Exception $e) {
            // Use 'error' for red pop-up
            return back()->withErrors(['email' => 'Could not send email.']);
        }
        
        // CHANGE THIS LINE: Use 'success' for green pop-up
        return back()->with('success', 'A new code has been sent to your email.');
    }
}