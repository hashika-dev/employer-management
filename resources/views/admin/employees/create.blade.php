<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create New Account
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg p-8 border border-gray-200">
                
                <div class="mb-6 border-b pb-4">
                    <h3 class="text-xl font-bold text-slate-700">Account Credentials</h3>
                    <p class="text-gray-500 text-sm">Enter the role and login details for the new user.</p>
                </div>

                @if ($errors->any())
                    <div class="mb-6 bg-red-50 text-red-600 p-4 rounded-md border border-red-200">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Ensure this route matches what is in your routes/web.php --}}
<form method="POST" action="{{ route('admin.employees.store') }}">
                    @csrf

                    {{-- REMOVED: Full Name Input --}}

                    {{-- Auto-Increment Employee ID Field (From previous step) --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Employee Number (Auto-Generated)</label>
<input type="text" 
       name="employee_number" 
       id="employee_number"
       value="{{ old('employee_number', $newEmployeeId) }}" 
       readonly 
       class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 cursor-not-allowed">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Department</label>
                            <select name="department_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="" disabled selected hidden></option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>
                                        {{ $dept->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Job Title</label>
                            <input type="text" name="job_title" placeholder="e.g. Developer" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ old('job_title') }}" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Email Address</label>
                        <input type="email" name="email" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ old('email') }}" required>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Default Password</label>
                        <input type="text" name="password" placeholder="e.g. password123" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    </div>

                    <div class="flex items-center justify-end space-x-4">
                        <a href="{{ route('admin.employees.index') }}" class="text-gray-600 hover:text-gray-900 font-medium">Cancel</a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-150">
                            Create & Send Email
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>