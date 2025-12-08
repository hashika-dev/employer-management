<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Attendance Logs - Employee List') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6 flex justify-end">
                <form method="GET" action="{{ route('admin.attendance.index') }}" class="flex gap-2">
                    <input type="text" name="search" placeholder="Search Employee..." value="{{ request('search') }}" 
                           class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-700">Search</button>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Employee Name</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Employee ID</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Email</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($employees as $emp)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900">
                                    {{-- FIX: Combine First and Last Name --}}
                                    {{ $emp->first_name }} {{ $emp->last_name }}
                                </div>
                                <div class="text-xs text-gray-400">
                                    {{-- Optional: Show Job Title below name --}}
                                    {{ $emp->job_title }}
                                </div>
                            </td>
                           <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{-- Checks if value exists, otherwise prints N/A --}}
                                @if(!empty($emp->employee_number))
                                    <span class="font-mono bg-gray-100 text-gray-700 py-1 px-2 rounded">
                                        {{ $emp->employee_number }}
                                    </span>
                                @else
                                    <span class="text-red-400 italic">No ID</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $emp->email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <a href="{{ route('admin.attendance.show', $emp->id) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    View History &rarr;
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="px-6 py-4">
                    {{ $employees->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>