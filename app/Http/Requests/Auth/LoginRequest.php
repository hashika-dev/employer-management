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
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'login_identifier' => ['required', 'string'],
            'password' => ['required', 'string'],
            
            // --- RESTORED CAPTCHA LOGIC ---
            'g-recaptcha-response' => [
                'required',
                function ($attribute, $value, $fail) {
                    $secret = env('RECAPTCHA_SECRET_KEY');
                    
                    if (!$secret) {
                        return; // Skip if no key (prevents crash on localhost without keys)
                    }

                    // Verify with Google
                    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$value");
                    $responseKeys = json_decode($response, true);
    
                    if (!$responseKeys["success"]) {
                        $fail('Please verify that you are not a robot.');
                    }
                },
            ],
            // -----------------------------
        ];
    }

    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $input = $this->input('login_identifier');

        // Smart Login: Email vs Employee Number
        $fieldType = filter_var($input, FILTER_VALIDATE_EMAIL) ? 'email' : 'employee_number';

        if (! Auth::attempt([$fieldType => $input, 'password' => $this->input('password')], $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'login_identifier' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

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

    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('login_identifier')).'|'.$this->ip());
    }
}