<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\User; // Assuming Admin users are in the User model

class AdminLoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Allow all users to attempt login
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'], // Admins typically use email
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     */
    public function authenticate(): void
    {
        // Check 1: If the user is currently locked out based on the counter
        $this->ensureIsNotRateLimited();

        $email = $this->input('email');
        
        // Check 2: If the user is permanently locked out in the database
        $user = User::where('email', $email)->first();

        if ($user && $user->is_locked) {
            throw ValidationException::withMessages([
                'email' => 'account_locked', // Special keyword for View to show modal
            ]);
        }

        // 3. Attempt Login (Targeting the 'admin' guard or checking role/email)
        // Since Admins are often regular users with a specific role, we use Auth::attempt 
        // and check the role afterwards, or use a specific admin guard if defined.
        // Assuming no dedicated 'admin' guard, we attempt standard login first:
        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            
            // Log the failed attempt and set the 15-minute decay time
            RateLimiter::hit($this->throttleKey(), 900);

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }
        
        // 4. Successful Login Checks
        $user = Auth::user();
        
        // SECURITY CHECK: Ensure the logged-in user is actually an administrator
        if ($user->role !== 'admin') { 
            Auth::logout(); // Kick them out if they are not an Admin
            throw ValidationException::withMessages([
                'email' => 'Access denied. You are not authorized as an administrator.',
            ]);
        }

        // Check if Archived
        if ($user->archived_at) {
            Auth::logout();
            throw ValidationException::withMessages([
                'email' => 'Your account has been SUSPENDED. Please contact the administrator.',
            ]);
        }

        // Clear the counter on successful login
        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited (3 attempts limit).
     */
    public function ensureIsNotRateLimited(): void
    {
        // 1. Check if attempts >= 3
        if (RateLimiter::tooManyAttempts($this->throttleKey(), 3)) {
            
            // 2. LOCK THE USER IN DATABASE (Permanent lock until OTP)
            $user = User::where('email', $this->input('email'))->first();

            if ($user) {
                $user->update(['is_locked' => 1]);
            }

            // 3. Throw special error to trigger the modal
            throw ValidationException::withMessages([
                'email' => 'account_locked',
            ]);
        }
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        // Throttle by email/user identifier and IP
        return Str::transliterate(Str::lower($this->input('email')).'|'.$this->ip());
    }
}