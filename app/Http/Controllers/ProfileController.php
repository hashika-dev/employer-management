<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash; // <--- Make sure this is imported at the top!

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        // No need to query Employee model anymore, everything is in User
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
   public function update(ProfileUpdateRequest $request): RedirectResponse
{
    $user = $request->user();
    $isLocked = $user->profile_completed == 1;

    // 1. Handle Photo Upload (Allowed even if locked)
    if ($request->hasFile('photo')) {
        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }
        $user->profile_photo_path = $request->file('photo')->store('profile-photos', 'public');
    }

    // 2. Handle Password Change (Allowed even if locked)
    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    // 3. Handle Personal Info (BLOCKED if locked)
    if (! $isLocked) {
        // Only update these fields if the profile is NOT locked
        $user->fill($request->except(['password', 'current_password', 'photo']));
        
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
    }

    // 4. Save Changes
    $user->save();

    // 5. Lock Profile Logic (Only runs if not yet locked)
    if (! $isLocked && !empty($user->first_name) && !empty($user->last_name) && !empty($user->birthday)) {
        $user->forceFill([
            'profile_completed' => 1,
            'is_setup' => 1 
        ])->save();
    }

    return Redirect::route('profile.edit')->with('status', 'profile-updated');
}
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