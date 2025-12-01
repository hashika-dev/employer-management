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
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            
                            <div>
                                <h4 class="text-lg font-bold text-slate-700 border-b pb-2 mb-4">Identity & Work</h4>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-xs text-gray-500 uppercase font-bold mb-1">First Name</label>
                                        <input type="text" name="first_name" value="{{ old('first_name', $employee->first_name) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-500 uppercase font-bold mb-1">Last Name</label>
                                        <input type="text" name="last_name" value="{{ old('last_name', $employee->last_name) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-500 uppercase font-bold mb-1">Job Title</label>
                                        <input type="text" name="job_title" value="{{ old('job_title', $employee->job_title) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h4 class="text-lg font-bold text-slate-700 border-b pb-2 mb-4">Contact Information</h4>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-xs text-gray-500 uppercase font-bold mb-1">Email Address</label>
                                        <input type="email" name="email" value="{{ old('email', $employee->email) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-500 uppercase font-bold mb-1">Phone Number</label>
                                        <input type="text" name="phone" value="{{ old('phone', $employee->phone) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-500 uppercase font-bold mb-1">Address</label>
                                        <textarea name="address" rows="2" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('address', $employee->address) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-span-1 md:col-span-2 mt-4">
    <h4 class="text-lg font-bold text-slate-700 border-b pb-2 mb-4">Emergency Contact</h4>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-xs text-gray-500 uppercase font-bold mb-1">Contact Name</label>
            <input type="text" name="emergency_name" value="{{ old('emergency_name', $employee->emergency_name) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="e.g. John Doe">
        </div>
        <div>
            <label class="block text-xs text-gray-500 uppercase font-bold mb-1">Relationship</label>
            <input type="text" name="emergency_relation" value="{{ old('emergency_relation', $employee->emergency_relation) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="e.g. Spouse">
        </div>
        <div>
            <label class="block text-xs text-gray-500 uppercase font-bold mb-1">Emergency Phone</label>
            <input type="text" name="emergency_phone" value="{{ old('emergency_phone', $employee->emergency_phone) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="e.g. 0912...">
        </div>
    </div>
</div>

                        <div class="mt-10 pt-6 border-t bg-gray-50 -mx-8 -mb-8 p-8 flex justify-end space-x-3">
                            <a href="{{ route('admin.employees.show', $employee->id) }}" class="text-gray-600 hover:text-gray-900 font-bold py-2 px-4 flex items-center">
                                Cancel
                            </a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-150">
                                Save Changes
                            </button>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>