<section class="max-w-5xl mx-auto pb-12">
    
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('patch')

        @php
            $isLocked = $user->profile_completed == 1;
        @endphp

        @if($isLocked)
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6 rounded-r shadow-sm flex items-center justify-between">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700 font-bold">Profile Locked</p>
                    <p class="text-xs text-yellow-600">Setup complete. Contact HR to edit.</p>
                </div>
            </div>
            <button type="button" onclick="openSupportModal()" class="text-xs font-bold text-yellow-700 underline hover:text-yellow-800">
                Contact HR
            </button>
        </div>
        @endif

        @if (session('status') === 'profile-locked')
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                <strong class="font-bold">Action Denied!</strong> Your profile is locked.
            </div>
        @endif

        <div class="bg-white shadow-sm rounded-2xl overflow-hidden border border-gray-100">
            
            <div class="bg-slate-800 p-8 flex flex-col md:flex-row items-center gap-8">
                
                <div class="flex-shrink-0 relative group">
                    <div class="inline-flex items-center justify-center w-28 h-28 rounded-full border-4 border-white/20 shadow-lg overflow-hidden bg-blue-600 relative">
                        <img id="avatar-image" 
                             src="{{ $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : '' }}" 
                             alt="Profile" 
                             class="w-full h-full object-cover {{ $user->profile_photo_path ? '' : 'hidden' }}">

                        <div id="avatar-initials" class="text-4xl font-bold text-white {{ $user->profile_photo_path ? 'hidden' : '' }}">
                            {{ substr($user->first_name, 0, 1) }}{{ substr($user->last_name, 0, 1) }}
                        </div>

                        @if(!$isLocked)
                        <label for="photo" class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </label>
                        @endif
                    </div>
                    @if(!$isLocked)
                    <input type="file" id="photo" name="photo" class="hidden" accept="image/*" onchange="previewImage(event)">
                    @endif
                </div>

                <div class="text-center md:text-left text-white flex-grow">
                    <h2 class="text-3xl font-bold tracking-tight">
                        {{ $user->first_name }} {{ $user->last_name }}
                    </h2>
                    <p class="text-blue-200 font-medium text-lg mt-1">{{ $user->job_title ?? 'Staff Member' }}</p>
                    
                    <x-input-error class="mt-2 text-red-200 bg-red-900/50 px-2 py-1 rounded inline-block" :messages="$errors->get('photo')" />

                    <div class="flex flex-wrap justify-center md:justify-start gap-4 mt-4 text-sm text-slate-300">
                        <span class="flex items-center gap-1 bg-slate-700/50 px-3 py-1 rounded-full">
                            <span class="text-slate-400 uppercase text-xs font-bold">ID:</span> 
                            <span class="font-mono text-white">{{ $user->employee_number }}</span>
                        </span>
                        <span class="flex items-center gap-1 bg-slate-700/50 px-3 py-1 rounded-full">
                            <span class="text-slate-400 uppercase text-xs font-bold">Dept:</span> 
                            <span class="text-white">{{ $user->department->name ?? 'None' }}</span>
                        </span>
                    </div>
                </div>
            </div>

            <div class="p-10">
                <h3 class="text-lg font-bold text-gray-800 mb-6 border-b pb-2">Identity Details</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
                    
                    <div class="md:col-span-5">
                        <x-input-label for="first_name" class="mb-2">
                            First Name <span class="text-red-500">*</span>
                        </x-input-label>
                        <x-text-input id="first_name" name="first_name" type="text" 
                            class="block w-full py-3 {{ $isLocked ? 'bg-gray-50 text-gray-500 cursor-not-allowed' : '' }}" 
                            :value="old('first_name', $user->first_name)" :readonly="$isLocked" required />
                        <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
                    </div>

                    <div class="md:col-span-2">
                        <x-input-label for="middle_initial" :value="__('M.I.')" class="mb-2" />
                        <x-text-input id="middle_initial" name="middle_initial" type="text" maxlength="5" 
                            class="block w-full text-center py-3 {{ $isLocked ? 'bg-gray-50 text-gray-500 cursor-not-allowed' : '' }}" 
                            :value="old('middle_initial', $user->middle_initial)" :readonly="$isLocked" />
                        <x-input-error class="mt-2" :messages="$errors->get('middle_initial')" />
                    </div>

                    <div class="md:col-span-5">
                        <x-input-label for="last_name" class="mb-2">
                            Last Name <span class="text-red-500">*</span>
                        </x-input-label>
                        <x-text-input id="last_name" name="last_name" type="text" 
                            class="block w-full py-3 {{ $isLocked ? 'bg-gray-50 text-gray-500 cursor-not-allowed' : '' }}" 
                            :value="old('last_name', $user->last_name)" :readonly="$isLocked" required />
                        <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
                    </div>

                    <div class="md:col-span-12 md:col-start-1 md:col-end-3">
                         <x-input-label for="suffix_name" :value="__('Suffix')" class="mb-2" />
                         <x-text-input id="suffix_name" name="suffix_name" type="text" 
                            class="block w-full py-3 {{ $isLocked ? 'bg-gray-50 text-gray-500 cursor-not-allowed' : '' }}" 
                            :value="old('suffix_name', $user->suffix_name)" :readonly="$isLocked" />
                         <x-input-error class="mt-2" :messages="$errors->get('suffix_name')" />
                    </div>

                    <div class="md:col-span-4 md:col-start-1">
                        <x-input-label for="birthday" class="mb-2">
                            Birthday <span class="text-red-500">*</span>
                        </x-input-label>
                        <x-text-input id="birthday" name="birthday" type="date" 
                            class="block w-full py-3 {{ $isLocked ? 'bg-gray-50 text-gray-500 cursor-not-allowed' : '' }}" 
                            :value="old('birthday', $user->birthday)" :readonly="$isLocked" />
                        <x-input-error class="mt-2" :messages="$errors->get('birthday')" />
                    </div>

                    <div class="md:col-span-4">
                        <x-input-label for="gender" class="mb-2">
                            Gender <span class="text-red-500">*</span>
                        </x-input-label>
                        @if($isLocked)
                            <x-text-input type="text" class="block w-full py-3 bg-gray-50 text-gray-500 cursor-not-allowed" :value="$user->gender" readonly />
                        @else
                            <select name="gender" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3">
                                <option value="" disabled selected>Select Gender</option>
                                <option value="Male" {{ old('gender', $user->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender', $user->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                        @endif
                        <x-input-error class="mt-2" :messages="$errors->get('gender')" />
                    </div>

                    <div class="md:col-span-4">
                        <x-input-label for="marital_status" class="mb-2">
                            Marital Status <span class="text-red-500">*</span>
                        </x-input-label>
                        @if($isLocked)
                            <x-text-input type="text" class="block w-full py-3 bg-gray-50 text-gray-500 cursor-not-allowed" :value="$user->marital_status" readonly />
                        @else
                            <select name="marital_status" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3">
                                <option value="" disabled selected>Select Status</option>
                                <option value="Single" {{ old('marital_status', $user->marital_status) == 'Single' ? 'selected' : '' }}>Single</option>
                                <option value="Married" {{ old('marital_status', $user->marital_status) == 'Married' ? 'selected' : '' }}>Married</option>
                                <option value="Divorced" {{ old('marital_status', $user->marital_status) == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                                <option value="Widowed" {{ old('marital_status', $user->marital_status) == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                            </select>
                        @endif
                        <x-input-error class="mt-2" :messages="$errors->get('marital_status')" />
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-sm rounded-2xl overflow-hidden border border-gray-100 p-10">
            <div class="flex items-center gap-4 mb-8">
                <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 00-2-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-800">Contact Information</h3>
                    <p class="text-gray-500 text-sm">Where can we reach you?</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <x-input-label for="email" :value="__('Email Address')" class="mb-2" />
                    <x-text-input id="email" name="email" type="email" class="block w-full bg-gray-50 text-gray-500 py-3 cursor-not-allowed" :value="old('email', $user->email)" readonly />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>

                <div>
                    <x-input-label for="phone" :value="__('Phone Number')" class="mb-2" />
                    <x-text-input id="phone" name="phone" type="text" 
                        class="block w-full py-3 {{ $isLocked ? 'bg-gray-50 text-gray-500 cursor-not-allowed' : '' }}" 
                        :value="old('phone', $user->phone)" placeholder="+1 (555) 000-0000" :readonly="$isLocked" />
                    <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                </div>

                <div class="md:col-span-2">
                    <x-input-label for="address" class="mb-2">
                        Home Address <span class="text-red-500">*</span>
                    </x-input-label>
                    <x-text-input id="address" name="address" type="text" 
                        class="block w-full py-3 {{ $isLocked ? 'bg-gray-50 text-gray-500 cursor-not-allowed' : '' }}" 
                        :value="old('address', $user->address)" placeholder="Street, City, State, Zip Code" :readonly="$isLocked" />
                    <x-input-error class="mt-2" :messages="$errors->get('address')" />
                </div>
            </div>
        </div>

        <div class="bg-white shadow-sm rounded-2xl overflow-hidden border-l-4 border-red-500 p-10">
            <div class="flex items-center gap-4 mb-8">
                <div class="p-3 bg-red-50 text-red-600 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-800">Emergency Contact</h3>
                    <p class="text-gray-500 text-sm">Required for safety purposes.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <x-input-label for="emergency_name" class="mb-2">
                        Contact Name <span class="text-red-500">*</span>
                    </x-input-label>
                    <x-text-input id="emergency_name" name="emergency_name" type="text" 
                        class="block w-full py-3 {{ $isLocked ? 'bg-gray-50 text-gray-500 cursor-not-allowed' : '' }}" 
                        :value="old('emergency_name', $user->emergency_name)" :readonly="$isLocked" />
                    <x-input-error class="mt-2" :messages="$errors->get('emergency_name')" />
                </div>

                <div>
                    <x-input-label for="emergency_relation" class="mb-2">
                        Relationship <span class="text-red-500">*</span>
                    </x-input-label>
                    <x-text-input id="emergency_relation" name="emergency_relation" type="text" 
                        class="block w-full py-3 {{ $isLocked ? 'bg-gray-50 text-gray-500 cursor-not-allowed' : '' }}" 
                        :value="old('emergency_relation', $user->emergency_relation)" placeholder="e.g. Spouse" :readonly="$isLocked" />
                    <x-input-error class="mt-2" :messages="$errors->get('emergency_relation')" />
                </div>

                <div>
                    <x-input-label for="emergency_phone" class="mb-2">
                        Phone Number <span class="text-red-500">*</span>
                    </x-input-label>
                    <x-text-input id="emergency_phone" name="emergency_phone" type="text" 
                        class="block w-full py-3 {{ $isLocked ? 'bg-gray-50 text-gray-500 cursor-not-allowed' : '' }}" 
                        :value="old('emergency_phone', $user->emergency_phone)" :readonly="$isLocked" />
                    <x-input-error class="mt-2" :messages="$errors->get('emergency_phone')" />
                </div>
            </div>
        </div>

       <div class="bg-white shadow-sm rounded-2xl overflow-hidden border border-gray-100 p-10">
            <div class="flex items-center gap-4 mb-8">
                <div class="p-3 bg-purple-50 text-purple-600 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-800">Account Security</h3>
                    <p class="text-gray-500 text-sm">Update your password to secure your account.</p>
                </div>
            </div>

            <div class="space-y-6">
                <div>
                    <x-input-label for="current_password" class="mb-2">
                        Current Password 
                    </x-input-label>
                    <x-text-input id="current_password" name="current_password" type="password" 
                        class="block w-full py-3" 
                        autocomplete="current-password" />
                    <x-input-error class="mt-2" :messages="$errors->get('current_password')" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <x-input-label for="password" class="mb-2">
                            New Password 
                        </x-input-label>
                        <x-text-input id="password" name="password" type="password" 
                            class="block w-full py-3" 
                            autocomplete="new-password" />
                        <x-input-error class="mt-2" :messages="$errors->get('password')" />
                        <p class="text-xs text-gray-400 mt-2">
                            Min 8 chars. 1 Uppercase, 1 Number, 1 Underscore (_).
                        </p>
                    </div>

                    <div>
                        <x-input-label for="password_confirmation" class="mb-2">
                            Confirm Password 
                        </x-input-label>
                        <x-text-input id="password_confirmation" name="password_confirmation" type="password" 
                            class="block w-full py-3" 
                            autocomplete="new-password" />
                        <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
                    </div>
                </div>
            </div>
        </div>

        
        <div class="flex items-center justify-end gap-6 pt-4">
            @if (session('status') === 'profile-updated')
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="flex items-center gap-2 text-green-600 bg-white px-4 py-2 rounded-lg shadow-sm border border-green-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-bold">Changes Saved</span>
                </div>
            @endif
            
            <x-primary-button class="px-10 py-4 text-base font-bold shadow-lg bg-blue-600 hover:bg-blue-700 hover:scale-105 transition-all duration-200">
                {{ __('Save Changes') }}
            </x-primary-button>
        </div>
        

    </form>
</section>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const output = document.getElementById('avatar-image');
            const initials = document.getElementById('avatar-initials');
            
            output.src = reader.result;
            output.classList.remove('hidden'); // Show image
            initials.classList.add('hidden');  // Hide initials
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>