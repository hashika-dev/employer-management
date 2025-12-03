<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Department</h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-lg shadow-lg">
                <form action="{{ route('admin.departments.update', $department->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Department Name</label>
                        <input type="text" name="name" value="{{ $department->name }}" class="w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Description</label>
                        <textarea name="description" class="w-full border-gray-300 rounded-md shadow-sm" rows="3">{{ $department->description }}</textarea>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('admin.departments.index') }}" class="text-gray-600 font-bold py-2 px-4">Cancel</a>
                        <button type="submit" class="bg-blue-600 text-white font-bold py-2 px-6 rounded-lg shadow-md">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>