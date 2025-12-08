<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
 public function rules(): array
{
    $user = $this->user();
    $isFirstSetup = $user->profile_completed == 0;
    $isLocked = $user->profile_completed == 1;

    // 1. BASE RULES (Email is always validated)
    $rules = [
        'email' => ['required', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
        'photo' => ['nullable', 'image', 'max:10240'],
    ];

    // 2. PERSONAL INFO RULES 
    // We ONLY enforce these if the profile is NOT locked.
    // If locked, we skip validation so they don't turn red when changing password.
    if (! $isLocked) {
        $rules = array_merge($rules, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['required', 'string', 'max:255'],
            'birthday'       => ['required', 'date'],
            'gender'         => ['required', 'string'],
            'marital_status' => ['required', 'string'],
            'address'        => ['required', 'string', 'max:500'],
            'emergency_name'     => ['required', 'string', 'max:255'],
            'emergency_relation' => ['required', 'string', 'max:255'],
            'emergency_phone'    => ['required', 'string', 'max:20'],
            
            // Optional fields
            'middle_initial' => ['nullable', 'string', 'max:5'],
            'suffix_name'    => ['nullable', 'string', 'max:10'],
            'phone'          => ['nullable', 'string', 'max:20'],
        ]);
    } else {
        // If locked, make them nullable so they don't trigger errors
        $rules = array_merge($rules, [
            'first_name' => ['nullable'],
            'last_name' => ['nullable'],
            'birthday' => ['nullable'],
            'gender' => ['nullable'],
            'marital_status' => ['nullable'],
            'address' => ['nullable'],
            'emergency_name' => ['nullable'],
            'emergency_relation' => ['nullable'],
            'emergency_phone' => ['nullable'],
        ]);
    }

    // 3. PASSWORD RULES
    // Current password is required ONLY if user is typing in the 'password' field
    $rules['current_password'] = ['nullable', 'required_with:password', 'current_password'];

    $rules['password'] = [
        $isFirstSetup ? 'required' : 'nullable', 
        'confirmed', 
        'string',
        'min:8',
        'regex:/[A-Z]/', // 1 Uppercase
        'regex:/[0-9]/', // 1 Number
        'regex:/[_]/',   // 1 Underscore
        'regex:/^[a-zA-Z0-9_]+$/', // Only letters, numbers, underscores
        
        // THIS PREVENTS REUSING OLD PASSWORD
        'different:current_password', 
    ];

    return $rules;
}

// OPTIONAL: Add custom error messages for better clarity
public function messages()
{
    return [
        'password.different' => 'Your new password must be different from your current password.',
        'password.regex' => 'Password must include Uppercase, Number, and Underscore (_) only.',
    ];
}
}