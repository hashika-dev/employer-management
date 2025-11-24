<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Employee: {{ $employee->first_name }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg sm:rounded-lg p-8">
                
                <form action="{{ route('admin.employees.update', $employee->id) }}" method="POST">
                    @csrf
                    @method('PUT') <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block font-bold mb-2">First Name</label>
                            <input type="text" name="first_name" value="{{ $employee->first_name }}" class="w-full border rounded p-2" required>
                        </div>
                        <div>
                            <label class="block font-bold mb-2">Last Name</label>
                            <input type="text" name="last_name" value="{{ $employee->last_name }}" class="w-full border rounded p-2" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-2">Job Title</label>
                        <input type="text" name="job_title" value="{{ $employee->job_title }}" class="w-full border rounded p-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-2">Email</label>
                        <input type="email" name="email" value="{{ $employee->email }}" class="w-full border rounded p-2">
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-2">Phone</label>
                        <input type="text" name="phone" value="{{ $employee->phone }}" class="w-full border rounded p-2">
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('admin.employees.index') }}" class="text-gray-600 font-bold py-2 px-4">Cancel</a>
                        <button type="submit" class="bg-indigo-600 text-white font-bold py-2 px-6 rounded hover:bg-indigo-700">Update Employee</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>