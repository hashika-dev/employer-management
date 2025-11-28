<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     * (This fixes the 'undefined method create' error)
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Display the ADMIN login view.
     */
    public function createAdmin(): View
    {
        return view('auth.admin-login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // --- 2FA LOGIC ---
        $user = auth()->user();
        
        // 1. Generate the code
        // Ensure your User model has the generateCode() method!
        if (method_exists($user, 'generateCode')) {
             $user->generateCode();
             
             // 2. Send the email
            try {
                \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\TwoFactorCode($user->two_factor_code));
            } catch (\Exception $e) {
                // If mail fails, just continue for now or log it
            }
            
            // 3. Redirect to verify
            return redirect()->route('verify.index'); 
        }

        // Fallback if no 2FA setup
        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}