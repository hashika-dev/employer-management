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
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        // --- NEW 2FA LOGIC START ---
        $user = auth()->user();
        
        // 1. Generate the code
        $user->generateCode();
        
        // 2. Send the email (This uses the Gmail settings from Step 2)
        try {
            \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\TwoFactorCode($user->two_factor_code));
        } catch (\Exception $e) {
            // If internet is off or settings wrong, show error but don't crash
            return redirect()->back()->withErrors(['email' => 'Could not send email. Check .env settings.']);
        }

        // 3. Redirect to a verification page (You need to create this route/view)
        return redirect()->route('verify.index'); 
        // ----------------------------
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
