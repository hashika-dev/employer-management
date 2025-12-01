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
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $input = $this->input('login_identifier');

        // Smart Login Logic: Check if input looks like an Email
        $fieldType = filter_var($input, FILTER_VALIDATE_EMAIL) ? 'email' : 'employee_number';

        // 1. Attempt Login
        if (! Auth::attempt([$fieldType => $input, 'password' => $this->input('password')], $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'login_identifier' => trans('auth.failed'),
            ]);
        }

        // 2. CHECK IF ARCHIVED (New Ban Logic)
        $user = Auth::user();
        if ($user->archived_at) {
            Auth::logout(); // Kick them out immediately
            
            throw ValidationException::withMessages([
                'login_identifier' => 'Your account has been archived. Please contact HR.',
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'login_identifier' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('login_identifier')).'|'.$this->ip());
    }
}