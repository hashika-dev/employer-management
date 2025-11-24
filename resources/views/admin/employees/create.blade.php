<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Hire New Employee
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg p-8 border border-gray-200">
                
                <div class="mb-6 border-b pb-4">
                    <h3 class="text-xl font-bold text-slate-700">New Hire Details</h3>
                    <p class="text-gray-500 text-sm">Enter the information for the new employee below.</p>
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

                <form action="{{ route('admin.employees.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">First Name</label>
                            <input type="text" name="first_name" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Last Name</label>
                            <input type="text" name="last_name" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Job Title / Position</label>
                        <input type="text" name="job_title" placeholder="e.g. Software Engineer" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Email Address</label>
                            <input type="email" name="email" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Phone Number</label>
                            <input type="text" name="phone" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <div class="flex items-center justify-end space-x-4">
                        <a href="{{ route('admin.employees.index') }}" class="text-gray-600 hover:text-gray-900 font-medium">Cancel</a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-150">
                            Save Employee
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
