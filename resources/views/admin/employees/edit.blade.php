<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Employee') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <form action="{{ route('admin.employees.update', $employee->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="bg-white overflow-hidden shadow-lg rounded-lg border border-gray-200">
                    
                    {{-- Header Section --}}
                    <div class="bg-slate-800 p-6 text-white flex justify-between items-center">
                        <div class="flex items-center space-x-4">
                            <div class="h-16 w-16 bg-blue-500 rounded-full flex items-center justify-center text-2xl font-bold border-2 border-white uppercase shadow-md">
                                {{ substr($employee->first_name, 0, 1) }}
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold">Editing Profile</h3>
                                <p class="text-blue-200">Update information below</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-8">
                        {{-- Global Error Check --}}
                        @if ($errors->any())
                            <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                                <p class="font-bold">Something went wrong!</p>
                                <ul class="list-disc ml-5 text-sm">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            
                            {{-- LEFT COLUMN: IDENTITY --}}
                            <div>
                                <h4 class="text-lg font-bold text-slate-700 border-b pb-2 mb-4">Identity & Work</h4>
                                <div class="space-y-4">
                                    
                                    {{-- ADDED: Employee ID Field (Read Only) --}}
                                    <div>
                                        <label class="block text-xs text-gray-500 uppercase font-bold mb-1">Employee ID</label>
                                        <input type="text" name="employee_number" value="{{ old('employee_number', $employee->employee_number) }}" 
                                               class="w-full border-gray-300 rounded-md shadow-sm bg-gray-100 text-gray-600 cursor-not-allowed focus:border-blue-500 focus:ring-blue-500" readonly>
                                        @error('employee_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                    </div>

                                    {{-- Row 1: First Name & Middle Initial --}}
                                    <div class="grid grid-cols-4 gap-4">
                                        <div class="col-span-3">
                                            <label class="block text-xs text-gray-500 uppercase font-bold mb-1">First Name</label>
                                            <input type="text" name="first_name" value="{{ old('first_name', $employee->first_name) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                            @error('first_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                        </div>
                                        <div class="col-span-1">
                                            <label class="block text-xs text-gray-500 uppercase font-bold mb-1">M.I.</label>
                                            <input type="text" name="middle_initial" value="{{ old('middle_initial', $employee->middle_initial) }}" maxlength="5" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        </div>
                                    </div>

                                    {{-- Row 2: Last Name & Suffix --}}
                                    <div class="grid grid-cols-4 gap-4">
                                        <div class="col-span-3">
                                            <label class="block text-xs text-gray-500 uppercase font-bold mb-1">Last Name</label>
                                            <input type="text" name="last_name" value="{{ old('last_name', $employee->last_name) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                            @error('last_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                        </div>
                                        <div class="col-span-1">
                                            <label class="block text-xs text-gray-500 uppercase font-bold mb-1">Suffix</label>
                                            <input type="text" name="suffix_name" value="{{ old('suffix_name', $employee->suffix_name) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-xs text-gray-500 uppercase font-bold mb-1">Job Title</label>
                                        <input type="text" name="job_title" value="{{ old('job_title', $employee->job_title) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    
                                    <div>
                                        <label class="block text-xs text-gray-500 uppercase font-bold mb-1">Department</label>
                                        <select name="department_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                            <option value="" disabled selected hidden></option>
                                            @foreach($departments as $dept)
                                                <option value="{{ $dept->id }}" {{ (old('department_id', $employee->department_id) == $dept->id) ? 'selected' : '' }}>
                                                    {{ $dept->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-xs text-gray-500 uppercase font-bold mb-1">Gender</label>
                                        <select name="gender" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                            <option value="" disabled selected hidden></option>
                                            <option value="Male" {{ old('gender', $employee->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                            <option value="Female" {{ old('gender', $employee->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{-- RIGHT COLUMN: CONTACT & PERSONAL --}}
                            <div>
                                <h4 class="text-lg font-bold text-slate-700 border-b pb-2 mb-4">Contact & Personal</h4>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-xs text-gray-500 uppercase font-bold mb-1">Email Address</label>
                                        <input type="email" name="email" value="{{ old('email', $employee->email) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-500 uppercase font-bold mb-1">Phone Number</label>
                                        <input type="text" name="phone" value="{{ old('phone', $employee->phone) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-500 uppercase font-bold mb-1">Address</label>
                                        <textarea name="address" rows="2" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('address', $employee->address) }}</textarea>
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-500 uppercase font-bold mb-1">Birthday</label>
                                        <input type="date" name="birthday" value="{{ old('birthday', $employee->birthday) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-500 uppercase font-bold mb-1">Marital Status</label>
                                        <select name="marital_status" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                            <option value="" disabled selected hidden></option>
                                            <option value="Single" {{ (old('marital_status', $employee->marital_status) == 'Single') ? 'selected' : '' }}>Single</option>
                                            <option value="Married" {{ (old('marital_status', $employee->marital_status) == 'Married') ? 'selected' : '' }}>Married</option>
                                            <option value="Divorced" {{ (old('marital_status', $employee->marital_status) == 'Divorced') ? 'selected' : '' }}>Divorced</option>
                                            <option value="Widowed" {{ (old('marital_status', $employee->marital_status) == 'Widowed') ? 'selected' : '' }}>Widowed</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- BOTTOM: EMERGENCY CONTACT --}}
                        <div class="mt-6 pt-4 border-t border-gray-200">
                            <h4 class="text-lg font-bold text-slate-700 mb-4">Emergency Contact</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-xs text-gray-500 uppercase font-bold mb-1">Contact Name</label>
                                    <input type="text" name="emergency_name" value="{{ old('emergency_name', $employee->emergency_name) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-500 uppercase font-bold mb-1">Relationship</label>
                                    <input type="text" name="emergency_relation" value="{{ old('emergency_relation', $employee->emergency_relation) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-500 uppercase font-bold mb-1">Phone</label>
                                    <input type="text" name="emergency_phone" value="{{ old('emergency_phone', $employee->emergency_phone) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                            </div>
                        </div>

                        {{-- FOOTER BUTTONS --}}
                        <div class="mt-10 pt-6 border-t bg-gray-50 -mx-8 -mb-8 p-8 flex justify-end space-x-3">
                            <a href="{{ route('admin.employees.show', $employee->id) }}" class="text-gray-600 hover:text-gray-900 font-bold py-2 px-4 flex items-center">Cancel</a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-150">Save Changes</button>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>