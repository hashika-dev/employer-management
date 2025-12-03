<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Employee Information') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            @if(Auth::user()->profile_completed)
                <span class="text-green-600 font-bold">✅ Profile Verified & Locked. Contact HR for changes.</span>
            @else
                Please complete your profile to activate your account. This can only be done once.
            @endif
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="employee_number" :value="__('Employee ID')" />
            <x-text-input id="employee_number" type="text" class="mt-1 block w-full bg-gray-100 text-gray-500 cursor-not-allowed" 
                :value="$user->employee_number" disabled />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <x-input-label for="first_name" :value="__('First Name')" />
                <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" 
                    :value="old('first_name', $employee->first_name ?? '')" required 
                    :disabled="Auth::user()->profile_completed" />
                <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
            </div>

            <div>
                <x-input-label for="last_name" :value="__('Last Name')" />
                <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full" 
                    :value="old('last_name', $employee->last_name ?? '')" required 
                    :disabled="Auth::user()->profile_completed" />
                <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <x-input-label for="gender" :value="__('Gender')" />
                <select id="gender" name="gender" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm disabled:bg-gray-100"
                    {{ Auth::user()->profile_completed ? 'disabled' : '' }}>
                    <option value="" disabled selected hidden></option>
                    <option value="Male" {{ (old('gender', $employee->gender ?? '') == 'Male') ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ (old('gender', $employee->gender ?? '') == 'Female') ? 'selected' : '' }}>Female</option>
                </select>
            </div>

            <div>
                <x-input-label for="marital_status" :value="__('Marital Status')" />
                <select id="marital_status" name="marital_status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm disabled:bg-gray-100"
                    {{ Auth::user()->profile_completed ? 'disabled' : '' }}>
                    <option value="" disabled selected hidden></option>
                    <option value="Single" {{ (old('marital_status', $employee->marital_status ?? '') == 'Single') ? 'selected' : '' }}>Single</option>
                    <option value="Married" {{ (old('marital_status', $employee->marital_status ?? '') == 'Married') ? 'selected' : '' }}>Married</option>
                    <option value="Divorced" {{ (old('marital_status', $employee->marital_status ?? '') == 'Divorced') ? 'selected' : '' }}>Divorced</option>
                    <option value="Widowed" {{ (old('marital_status', $employee->marital_status ?? '') == 'Widowed') ? 'selected' : '' }}>Widowed</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <x-input-label for="birthday" :value="__('Date of Birth')" />
                <x-text-input id="birthday" name="birthday" type="date" class="mt-1 block w-full" 
                    :value="old('birthday', $employee->birthday ?? '')" 
                    :disabled="Auth::user()->profile_completed" />
            </div>

            <div>
                <x-input-label for="phone" :value="__('Phone Number')" />
                <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" 
                    :value="old('phone', $employee->phone ?? '')" 
                    :disabled="Auth::user()->profile_completed" />
            </div>
        </div>

        <div>
            <x-input-label for="address" :value="__('Home Address')" />
            <textarea id="address" name="address" rows="2" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm disabled:bg-gray-100"
                {{ Auth::user()->profile_completed ? 'disabled' : '' }}>{{ old('address', $employee->address ?? '') }}</textarea>
        </div>

        <div>
            <x-input-label for="email" :value="__('Email Address')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required 
                :disabled="Auth::user()->profile_completed" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <div class="border-t border-gray-200 pt-6 mt-6">
            <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4">Emergency Contact</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <x-input-label for="emergency_name" :value="__('Contact Name')" />
                    <x-text-input id="emergency_name" name="emergency_name" type="text" class="mt-1 block w-full" 
                        :value="old('emergency_name', $employee->emergency_name ?? '')" 
                        :disabled="Auth::user()->profile_completed" />
                </div>
                <div>
                    <x-input-label for="emergency_relation" :value="__('Relationship')" />
                    <x-text-input id="emergency_relation" name="emergency_relation" type="text" class="mt-1 block w-full" 
                        :value="old('emergency_relation', $employee->emergency_relation ?? '')" 
                        :disabled="Auth::user()->profile_completed" />
                </div>
                <div>
                    <x-input-label for="emergency_phone" :value="__('Emergency Phone')" />
                    <x-text-input id="emergency_phone" name="emergency_phone" type="text" class="mt-1 block w-full" 
                        :value="old('emergency_phone', $employee->emergency_phone ?? '')" 
                        :disabled="Auth::user()->profile_completed" />
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4 mt-6">
            @if(!Auth::user()->profile_completed)
                <x-primary-button>{{ __('Save & Finalize Profile') }}</x-primary-button>
            @else
                <div class="text-sm text-gray-500 italic bg-gray-100 px-4 py-2 rounded">
                    (Editing disabled. Please contact Admin if you need to update info.)
                </div>
            @endif
        </div>
    </form>
</section>