<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Staff Directory') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                <h3 class="text-2xl font-bold text-slate-700">Team Members</h3>
                <a href="{{ route('admin.employees.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-150">
                    + Hire New Employee
                </a>
            </div>

            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 mb-6">
                <form method="GET" action="{{ route('admin.employees.index') }}" class="flex flex-col md:flex-row gap-4">
                    <div class="flex-grow relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" 
                            class="pl-10 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" 
                            placeholder="Search by name, email, or job title...">
                    </div>
                   <div class="w-full md:w-48">
                        <select name="sort" onchange="this.form.submit()" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <option value="" disabled {{ !request('sort') ? 'selected' : '' }}>Sort By...</option>
                            <option value="date_oldest" {{ request('sort') == 'date_oldest' ? 'selected' : '' }}>Longest Tenure</option>
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
                            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name (Z-A)</option>
                        </select>
                    </div>
                    <button type="submit" class="bg-slate-800 hover:bg-slate-700 text-white font-bold py-2 px-4 rounded-lg transition">Filter</button>
                    @if(request()->has('search') || request()->has('sort'))
                        <a href="{{ route('admin.employees.index') }}" class="flex items-center text-gray-500 hover:text-red-500 font-medium px-2">Clear</a>
                    @endif
                </form>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm flex items-center">
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Full Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Job Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact Info</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($employees as $employee)
                            @php
                                $isArchived = $employee->archived_at !== null;
                            @endphp
                        <tr class="hover:bg-gray-50 transition duration-150 {{ $isArchived ? 'bg-red-50' : '' }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="text-sm font-bold text-gray-900 mr-2">
                                        {{-- LOGIC CHANGE HERE: Check if name exists --}}
                                        @if($employee->first_name)
                                            {{ $employee->first_name }} 
                                            {{ $employee->middle_initial ? $employee->middle_initial . '.' : '' }}
                                            {{ $employee->last_name }} 
                                            {{ $employee->suffix_name }}
                                        @else
                                            <span class="text-red-500 italic font-normal">Pending Setup...</span>
                                        @endif
                                    </div>
                                    @if($isArchived)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 border border-red-200">
                                            ARCHIVED
                                        </span>
                                    @endif
                                </div>
                                <div class="text-xs text-gray-400">{{ $employee->employee_number }}</div>
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                    {{ $employee->job_title ?? 'N/A' }}
                                </span>
                                <div class="text-xs text-gray-400 mt-1">
                                    {{ $employee->department ? $employee->department->name : '-' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div>{{ $employee->email }}</div>
                                <div class="text-xs text-gray-400">{{ $employee->phone }}</div>
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.employees.show', $employee->id) }}" class="text-blue-600 hover:text-blue-900 font-bold inline-flex items-center bg-blue-50 hover:bg-blue-100 border border-blue-200 px-3 py-1 rounded transition">
                                    View Details
                                </a>
                            </td>
                        </tr>
                        @endforeach

                        @if($employees->isEmpty())
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                                No employees found.
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
                <div class="p-4">
                    {{ $employees->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>