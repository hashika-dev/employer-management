<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException; // <--- Added this import

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
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
        // 1. Attempt to login
        $request->authenticate();

        $request->session()->regenerate();

        $user = auth()->user();

        // --- NEW: CHECK IF ACCOUNT IS ARCHIVED ---
        if ($user->archived_at) {
            
            // Immediately log them out
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Throw the error with your custom text
            throw ValidationException::withMessages([
                'email' => 'Your account has been SUSPENDED. Please contact HR.',
            ]);
        }

        // --- 2FA LOGIC (Keep your existing commented code) ---
        /*
        if (method_exists($user, 'generateCode')) {
             $user->generateCode();
             try {
                \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\TwoFactorCode($user->two_factor_code));
             } catch (\Exception $e) { }
            
             return redirect()->route('verify.index'); 
        }
        */

        // 3. Normal Redirection
        if ($user->role === 'admin') {
            return redirect()->intended(route('admin.dashboard', absolute: false));
        }

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