<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\Employee; // <--- Add this line

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

        // 1. Create the Login Account (User)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // Default role
        ]);

        // --- NEW CODE START ---
        // 2. Automatically create the Employee Record
        // We split the "Name" into First and Last for the employee table
        $parts = explode(' ', $request->name, 2);
        $firstName = $parts[0]; 
        $lastName = isset($parts[1]) ? $parts[1] : '(No Last Name)';

        Employee::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $request->email,
            'job_title' => 'New Recruit', // Default title
            'phone' => 'N/A',
        ]);
        // --- NEW CODE END ---

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
