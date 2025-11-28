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
        // We find the employee record by the User's email
        $employee = Employee::where('email', $user->email)->first();
        
        if ($employee) {
            $employee->update([
                'first_name'     => $request->first_name,
                'last_name'      => $request->last_name,
                'phone'          => $request->phone,
                'address'        => $request->address,
                'birthday'       => $request->birthday,
                'marital_status' => $request->marital_status,
                // Calculate age automatically from birthday
                'age'            => \Carbon\Carbon::parse($request->birthday)->age,
            ]);
            
            // Sync User's "name" to be "First Last" (Optional, keeps top bar pretty)
            $user->name = $request->first_name . ' ' . $request->last_name;
        }

        // 2. Update User Account Data (Email & Login Info)
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
            // Also update the employee email so the link isn't broken
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