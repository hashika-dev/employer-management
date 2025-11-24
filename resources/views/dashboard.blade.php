<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Simple Welcome Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-blue-500">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold text-slate-800">Hello, {{ Auth::user()->name }}!</h3>
                    <p class="mt-2 text-gray-600">
                        Welcome to the Employee Portal. You are logged in and ready to go.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>