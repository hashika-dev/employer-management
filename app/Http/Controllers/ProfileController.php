<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Employee;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        // Find the linked Employee record using the User's email
        $employee = Employee::where('email', $request->user()->email)->first();

        return view('profile.edit', [
            'user' => $request->user(),
            'employee' => $employee, // Pass employee data to the view
        ]);
    }

    /**
     * Update the user's profile information.
     */
  public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        
        // 1. Update Employee Details (The HR Data)
        $employee = Employee::where('email', $user->email)->first();
        
        if ($employee) {
            $employee->update([
                'first_name'     => $request->first_name,
                'last_name'      => $request->last_name,
                'phone'          => $request->phone,
                'address'        => $request->address,
                'birthday'       => $request->birthday,
                'marital_status' => $request->marital_status,
                'age'            => $request->birthday ? \Carbon\Carbon::parse($request->birthday)->age : null,
                
                // Emergency Fields
                'emergency_name'     => $request->emergency_name,
                'emergency_relation' => $request->emergency_relation,
                'emergency_phone'    => $request->emergency_phone,
            ]);
            
            // Sync User's "name"
            $user->name = $request->first_name . ' ' . $request->last_name;
        }

        // 2. Update User Account Data (FIXED)
        // We use ->only('email') so we don't try to save address/phone into the User table
        $user->fill($request->only('email'));

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
            
            // Also update the employee email so they stay linked
            if ($employee) {
                $employee->email = $request->email;
                $employee->save();
            }
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}