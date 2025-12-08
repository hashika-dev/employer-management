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
   /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validate the 4 specific name parts (Removing 'name')
        $request->validate([
            'first_name'     => ['required', 'string', 'max:255'],
            'middle_initial' => ['nullable', 'string', 'max:5'],
            'last_name'      => ['required', 'string', 'max:255'],
            'suffix_name'    => ['nullable', 'string', 'max:10'],
            'email'          => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password'       => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // 2. Create User (Saving the 4 parts directly)
        $user = User::create([
            'first_name'     => $request->first_name,
            'middle_initial' => $request->middle_initial,
            'last_name'      => $request->last_name,
            'suffix_name'    => $request->suffix_name,
            'email'          => $request->email,
            'password'       => Hash::make($request->password),
            'role'           => 'user',
        ]);

        // 3. Create Employee Record (No more 'explode' needed!)
        Employee::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'job_title'  => 'New Recruit',
            'phone'      => 'N/A',
            // Note: If you want to save Middle/Suffix to employees too, 
            // ensure the employees table has those columns first.
        ]);

        event(new Registered($user));

        // 4. Login the User
        Auth::login($user);

        // 5. FORCE 2FA: Generate Code NOW
        $user->generateCode();

        // 6. Send Email
        try {
            Mail::to($user->email)->send(new TwoFactorCode($user->two_factor_code));
        } catch (\Exception $e) {
            // Log error if needed, but proceed
        }

        // 7. Redirect to Verify Page
        return redirect()->route('verify.index');
    }
}
