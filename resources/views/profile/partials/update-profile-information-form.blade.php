<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Employee Information') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            Update your personal details and contact information.
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="employee_number" :value="__('Employee ID (Cannot be changed)')" />
            <x-text-input id="employee_number" type="text" class="mt-1 block w-full bg-gray-100 text-gray-500 cursor-not-allowed" 
                :value="$user->employee_number" disabled />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <x-input-label for="first_name" :value="__('First Name')" />
                <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" 
                    :value="old('first_name', $employee->first_name ?? '')" required autofocus />
                <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
            </div>

            <div>
                <x-input-label for="last_name" :value="__('Last Name')" />
                <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full" 
                    :value="old('last_name', $employee->last_name ?? '')" required />
                <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <x-input-label for="birthday" :value="__('Date of Birth')" />
                <x-text-input id="birthday" name="birthday" type="date" class="mt-1 block w-full" 
                    :value="old('birthday', $employee->birthday ?? '')" />
            </div>

            <div>
                <x-input-label for="marital_status" :value="__('Marital Status')" />
                <select id="marital_status" name="marital_status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option value="">Select Status</option>
                    <option value="Single" {{ (old('marital_status', $employee->marital_status ?? '') == 'Single') ? 'selected' : '' }}>Single</option>
                    <option value="Married" {{ (old('marital_status', $employee->marital_status ?? '') == 'Married') ? 'selected' : '' }}>Married</option>
                    <option value="Divorced" {{ (old('marital_status', $employee->marital_status ?? '') == 'Divorced') ? 'selected' : '' }}>Divorced</option>
                    <option value="Widowed" {{ (old('marital_status', $employee->marital_status ?? '') == 'Widowed') ? 'selected' : '' }}>Widowed</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <x-input-label for="phone" :value="__('Phone Number')" />
                <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" 
                    :value="old('phone', $employee->phone ?? '')" />
            </div>

            <div>
                <x-input-label for="email" :value="__('Email Address')" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
            </div>
        </div>

        <div>
            <x-input-label for="address" :value="__('Home Address')" />
            <textarea id="address" name="address" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('address', $employee->address ?? '') }}</textarea>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save Changes') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>