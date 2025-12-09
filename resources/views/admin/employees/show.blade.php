<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-slate-800 leading-tight">
                {{ __('Employee Profile') }}
            </h2>
            @if($employee->archived_at)
                {{-- UPDATED LABEL --}}
                <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-bold border border-red-200 animate-pulse">
                    ⛔ SUSPENDED ACCOUNT
                </span>
            @else
                <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold border border-green-200">
                    ✅ ACTIVE STAFF
                </span>
            @endif
        </div>
    </x-slot>

    {{-- UPDATED: Changed variable name to 'showSuspendModal' --}}
    <div class="py-12 bg-slate-50 min-h-screen" x-data="{ showSuspendModal: false }">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-slate-200 animate-scale-in">
                
                <div class="h-32 bg-gradient-to-r from-slate-800 to-blue-900 relative">
                    <div class="absolute top-4 right-4 text-white/20">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path></svg>
                    </div>
                </div>

                <div class="px-8 pb-8 relative">
                    
                    <div class="flex flex-col md:flex-row items-start mb-6 gap-6">
                        
                       <div class="flex-shrink-0">
    <div class="inline-flex items-center justify-center w-28 h-28 rounded-full border-4 border-blue-50 shadow-sm overflow-hidden bg-blue-600">
        
        @if($employee->profile_photo_path)
            <img src="{{ asset('storage/' . $employee->profile_photo_path) }}" 
                 alt="{{ $employee->first_name }}'s Photo" 
                 class="w-full h-full object-cover">
        @else
            <span class="text-4xl font-bold text-white">
                {{ substr($employee->first_name, 0, 1) }}{{ substr($employee->last_name, 0, 1) }}
            </span>
        @endif
    </div>
</div>
                        
                        <div class="flex-grow pt-2 min-w-0">
                            <h1 class="text-3xl font-extrabold text-slate-900 break-words leading-tight">
                                {{ $employee->name }}
                            </h1>
                            <p class="text-blue-600 font-medium text-lg truncate">
                                {{ $employee->job_title }}    
                            </p>
                            <p class="text-blue-200 opacity-75 text-sm uppercase tracking-wide">
                             {{ $employee->department ? $employee->department->name : 'No Department' }}
                            </p>
                        </div>

                        <div class="mt-2 md:mt-0 flex-shrink-0">
                            <div class="bg-slate-100 px-4 py-2 rounded-lg border border-slate-200 text-center">
                                <span class="block text-xs text-slate-500 uppercase font-bold tracking-wider">Employee ID</span>
                                <span class="block text-xl font-mono font-bold text-slate-800">{{ $employee->employee_number ?? '---' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8">
                        
                        <div class="bg-slate-50 p-6 rounded-xl border border-slate-100 hover:shadow-md transition-shadow duration-300">
                            <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-4 border-b border-slate-200 pb-2">Contact Information</h3>
                            <ul class="space-y-4">
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-blue-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    <div class="min-w-0 break-all">
                                        <span class="block text-xs text-slate-500">Email Address</span>
                                        <span class="text-slate-800 font-medium">{{ $employee->email }}</span>
                                    </div>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-blue-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    <div>
                                        <span class="block text-xs text-slate-500">Phone Number</span>
                                        <span class="text-slate-800 font-medium">{{ $employee->phone ?? 'Not set' }}</span>
                                    </div>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-blue-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    <div>
                                        <span class="block text-xs text-slate-500">Home Address</span>
                                        <span class="text-slate-800 font-medium">{{ $employee->address ?? 'Not set' }}</span>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div class="bg-slate-50 p-6 rounded-xl border border-slate-100 hover:shadow-md transition-shadow duration-300">
                            <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-4 border-b border-slate-200 pb-2">Personal Details</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <span class="block text-xs text-slate-500">Date of Birth</span>
                                    <span class="text-slate-800 font-medium">{{ $employee->birthday ? \Carbon\Carbon::parse($employee->birthday)->format('M d, Y') : 'N/A' }}</span>
                                </div>
                                <div>
                                    <span class="block text-xs text-slate-500">Age</span>
                                    <span class="text-slate-800 font-medium">
                                        {{ $employee->birthday ? \Carbon\Carbon::parse($employee->birthday)->age : 'N/A' }} Years
                                    </span>
                                </div>
                                <div>
                                    <span class="block text-xs text-slate-500">Marital Status</span>
                                    <span class="text-slate-800 font-medium">{{ $employee->marital_status ?? 'N/A' }}</span>
                                </div>
                                <div>
                                    <span class="block text-xs text-slate-500">Joined</span>
                                    <span class="text-slate-800 font-medium">{{ $employee->created_at->format('M Y') }}</span>
                                </div>
                            </div>
                            
                            <div class="mt-6 pt-4 border-t border-slate-200">
                                <h4 class="text-xs font-bold text-slate-400 uppercase mb-2">Emergency Contact</h4>
                                @if($employee->emergency_name)
                                    <div class="flex items-center bg-red-50 p-3 rounded-lg border border-red-100">
                                        <div class="bg-red-100 p-2 rounded-full mr-3 text-red-500">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M12 9v5m0 0v-5m0 5h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                        </div>
                                        <div>
                                            <p class="text-slate-900 font-bold">{{ $employee->emergency_name }} <span class="text-xs text-slate-500 font-normal">({{ $employee->emergency_relation }})</span></p>
                                            <p class="text-slate-600 text-sm font-mono">{{ $employee->emergency_phone }}</p>
                                        </div>
                                    </div>
                                @else
                                    <p class="text-sm text-slate-400 italic flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        No emergency contact info added yet.
                                    </p>
                                @endif
                            </div>
                        </div>

                    </div>

                    {{-- FOOTER BUTTONS --}}
                    <div class="mt-10 flex flex-col sm:flex-row justify-between items-center pt-6 border-t border-slate-100 gap-4">
                        <a href="{{ route('admin.employees.index') }}" class="text-slate-500 hover:text-slate-800 font-medium flex items-center transition">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Back to Directory
                        </a>

                        <div class="flex flex-wrap justify-center sm:justify-end gap-3 w-full sm:w-auto">
                            {{-- UPDATED: Use showSuspendModal, 'Suspend User', and 'Restore Access' --}}
                            <button @click="showSuspendModal = true" class="px-4 py-2 rounded-lg font-bold text-sm shadow-sm transition transform hover:-translate-y-0.5 {{ $employee->archived_at ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-amber-100 text-amber-700 hover:bg-amber-200' }}">
                                {{ $employee->archived_at ? 'Restore Access' : 'Suspend User' }}
                            </button>

                            <a href="{{ route('admin.employees.edit', $employee->id) }}" class="px-4 py-2 rounded-lg bg-blue-600 text-white font-bold text-sm shadow-md hover:bg-blue-700 transition transform hover:-translate-y-0.5">
                                Edit Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- UPDATED: Changed 'showArchiveModal' to 'showSuspendModal' --}}
        <div x-show="showSuspendModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 text-center">
                <div x-show="showSuspendModal" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>

                <div x-show="showSuspendModal" class="inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl relative z-10">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full {{ $employee->archived_at ? 'bg-green-100' : 'bg-amber-100' }} sm:mx-0 sm:h-10 sm:w-10">
                            @if($employee->archived_at)
                                <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            @else
                                <svg class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg>
                            @endif
                        </div>
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                            {{-- UPDATED: Text Changed to 'Suspend' --}}
                            <h3 class="text-lg font-bold leading-6 text-gray-900">{{ $employee->archived_at ? 'Restore Access?' : 'Suspend User Account?' }}</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    @if($employee->archived_at)
                                        This will restore access for <strong>{{ $employee->name }}</strong>. They will be able to log in immediately.
                                    @else
                                        {{-- UPDATED: Text Changed to 'Suspend' --}}
                                        Are you sure you want to suspend <strong>{{ $employee->name }}</strong>? They will be instantly banned from logging in. Data is preserved.
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                        {{-- NOTE: We keep the route name 'admin.employees.archive' to prevent errors --}}
                        <form action="{{ route('admin.employees.archive', $employee->id) }}" method="POST">
                            @csrf
                            {{-- UPDATED: Button Text Changed --}}
                            <button type="submit" class="inline-flex w-full justify-center rounded-md px-3 py-2 text-sm font-semibold text-white shadow-sm sm:ml-3 sm:w-auto {{ $employee->archived_at ? 'bg-green-600 hover:bg-green-500' : 'bg-amber-600 hover:bg-amber-500' }}">
                                {{ $employee->archived_at ? 'Confirm Restore' : 'Confirm Suspend' }}
                            </button>
                        </form>
                        <button @click="showSuspendModal = false" type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>