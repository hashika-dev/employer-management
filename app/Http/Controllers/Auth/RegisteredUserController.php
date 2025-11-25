<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\Employee; // <--- Add this line
use App\Mail\TwoFactorCode;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // 1. Create User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        // 2. Create Employee Record
        $parts = explode(' ', $request->name, 2);
        $firstName = $parts[0];
        $lastName = isset($parts[1]) ? $parts[1] : '(No Last Name)';

        Employee::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $request->email,
            'job_title' => 'New Recruit',
            'phone' => 'N/A',
        ]);

        event(new Registered($user));

        // 3. Login the User
        Auth::login($user);

        // 4. FORCE 2FA: Generate Code NOW
        $user->generateCode();

        // 5. Send Email (Try/Catch prevents crash if offline)
        try {
            Mail::to($user->email)->send(new TwoFactorCode($user->two_factor_code));
        } catch (\Exception $e) {
            // Log error if needed, but proceed to verify page
        }

        // 6. Redirect to Verify Page (NOT Dashboard)
        return redirect()->route('verify.index');
    }
}
