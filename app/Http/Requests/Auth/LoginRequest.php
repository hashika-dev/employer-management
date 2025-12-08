<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            // 1. Accept Email or ID
            'login_identifier' => ['required', 'string'],
            'password' => ['required', 'string'],
            
            // 2. RECAPTCHA CHECK
            'g-recaptcha-response' => [
                'required',
                function ($attribute, $value, $fail) {
                    $secret = env('RECAPTCHA_SECRET_KEY');
                    
                    // If no key is set in .env, skip check (prevents crash on localhost)
                    if (!$secret) {
                        return; 
                    }

                    // Verify with Google
                    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$value");
                    $responseKeys = json_decode($response, true);
    
                    if (!$responseKeys["success"]) {
                        $fail('Please verify that you are not a robot.');
                    }
                },
            ],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     */
    /**
     * Attempt to authenticate the request's credentials.
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $input = $this->input('login_identifier');
        $fieldType = filter_var($input, FILTER_VALIDATE_EMAIL) ? 'email' : 'employee_number';

        if (! Auth::attempt([$fieldType => $input, 'password' => $this->input('password')], $this->boolean('remember'))) {
            
            // 1. Get current attempts *before* this failed hit
            $currentAttempts = RateLimiter::attempts($this->throttleKey());
            
            // 2. Increment the counter immediately and set the 15-minute decay
            RateLimiter::hit($this->throttleKey(), 900);

            // 3. Calculate remaining attempts (Limit is 3)
            $newAttempts = $currentAttempts + 1;
            $remaining = 3 - $newAttempts;
            
            if ($remaining > 0) {
                // Attempts 1 and 2
                $message = "Invalid login details. You have {$remaining} more attempts before your account is locked.";
            } else if ($remaining == 0) {
                // Attempt 3 (The final warning before the lock is triggered on the 4th request)
                $message = "Invalid login details. This is your final attempt before your account is locked.";
            } else {
                // Attempts > 3 (Should be caught by ensureIsNotRateLimited, but for safety)
                $message = trans('auth.failed');
            }

            throw ValidationException::withMessages([
                'login_identifier' => $message,
            ]);
        }

        // 2. CHECK IF ARCHIVED (New Ban Logic)
        $user = Auth::user();
        if ($user->archived_at) {
            Auth::logout();
            
            throw ValidationException::withMessages([
                'login_identifier' => 'Your account has been SUSPENDED. Please contact the administrator.',
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    public function ensureIsNotRateLimited(): void
    {
        // Check if attempts >= 3
        if (RateLimiter::tooManyAttempts($this->throttleKey(), 3)) {
            
            // LOCK THE USER IN DATABASE
            $user = \App\Models\User::where('email', $this->input('login_identifier'))
                    ->orWhere('employee_number', $this->input('login_identifier'))
                    ->first();

            if ($user) {
                $user->update(['is_locked' => 1]);
            }

            // Throw special error to trigger the button
            throw ValidationException::withMessages([
                'login_identifier' => 'account_locked',
            ]);
        }
    }
    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('login_identifier')).'|'.$this->ip());
    }
}