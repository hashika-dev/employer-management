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
                        <select name="sort" onchange="this.form.submit()" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="date_newest" {{ request('sort') == 'date_newest' ? 'selected' : '' }}>Newest Hires</option>
                            <option value="date_oldest" {{ request('sort') == 'date_oldest' ? 'selected' : '' }}>Oldest Hires</option>
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
                            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name (Z-A)</option>
                            <option value="job" {{ request('sort') == 'job' ? 'selected' : '' }}>Job Title</option>
                        </select>
                    </div>

                    <button type="submit" class="bg-slate-800 hover:bg-slate-700 text-white font-bold py-2 px-4 rounded-lg transition">
                        Filter
                    </button>
                    
                    @if(request()->has('search') || request()->has('sort'))
                        <a href="{{ route('admin.employees.index') }}" class="flex items-center text-gray-500 hover:text-red-500 font-medium px-2">
                            Clear
                        </a>
                    @endif
                </form>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
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
                                $user = \App\Models\User::where('email', $employee->email)->first();
                                $isArchived = $user && $user->archived_at;
                            @endphp
                        <tr class="hover:bg-gray-50 transition duration-150 {{ $isArchived ? 'bg-red-50' : '' }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="text-sm font-bold text-gray-900 mr-2">
                                        {{ $employee->first_name }} {{ $employee->last_name }}
                                    </div>
                                    @if($isArchived)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 border border-red-200">
                                            ARCHIVED
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                    {{ $employee->job_title }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div>{{ $employee->email }}</div>
                                <div class="text-xs text-gray-400">{{ $employee->phone }}</div>
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.employees.show', $employee->id) }}" class="text-blue-600 hover:text-blue-900 font-bold inline-flex items-center bg-blue-50 hover:bg-blue-100 border border-blue-200 px-3 py-1 rounded transition">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    View Details
                                </a>
                            </td>
                        </tr>
                        @endforeach

                        @if($employees->isEmpty())
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                                @if(request('search'))
                                    No employees found matching "<strong>{{ request('search') }}</strong>". <a href="{{ route('admin.employees.index') }}" class="text-blue-600 hover:underline">Clear Search</a>
                                @else
                                    No employees found.
                                @endif
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>