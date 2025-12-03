<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center animate-fade-in-up">
            <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                {{ __('Employee Dashboard') }}
            </h2>
            <span class="text-sm text-slate-500 bg-white px-3 py-1 rounded-full shadow-sm border border-slate-200">
                {{ now()->format('l, F j, Y') }}
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="relative overflow-hidden bg-gradient-to-r from-slate-800 to-slate-900 rounded-3xl shadow-xl animate-fade-in-up">
                <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 bg-white opacity-5 rounded-full blur-3xl"></div>
                
                <div class="relative p-8 md:p-10 text-white">
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="h-12 w-12 bg-blue-600 rounded-lg flex items-center justify-center font-bold text-xl">
                            {{ substr(Auth::user()->employee_number ?? 'U', 0, 1) }}
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold tracking-tight">
                                {{ Auth::user()->name }}
                            </h3>
                            <p class="text-blue-200 text-sm font-mono">
                                {{ Auth::user()->employee_number ?? 'No ID' }}
                            </p>
                        </div>
                    </div>
                    
                    <p class="text-slate-300 text-lg max-w-2xl leading-relaxed">
                        @if(Auth::user()->profile_completed)
                            You are all set! Your profile is active and up to date.
                        @else
                            Welcome! Please complete your profile setup to access full features.
                        @endif
                    </p>
                    
                    <div class="mt-8 flex space-x-4">
                        @if(!Auth::user()->profile_completed)
                            <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-bold rounded-lg text-slate-900 bg-yellow-400 hover:bg-yellow-300 transition shadow-lg animate-pulse">
                                ⚠️ Complete My Profile
                            </a>
                        @else
                            <button class="inline-flex items-center px-6 py-3 border border-white/20 bg-white/10 text-white text-sm font-bold rounded-lg cursor-default">
                                ✅ Profile Active
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 animate-fade-in-up delay-200">
                
                <div class="group block bg-white overflow-hidden shadow-sm rounded-2xl border border-slate-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="p-6">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <h4 class="text-lg font-bold text-slate-800 mb-2">Account Status</h4>
                        <p class="text-slate-500 text-sm">
                            {{ Auth::user()->profile_completed ? 'Verified & Active' : 'Pending Setup' }}
                        </p>
                    </div>
                </div>

                <div class="group block bg-white overflow-hidden shadow-sm rounded-2xl border border-slate-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="p-6">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center text-green-600 mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <h4 class="text-lg font-bold text-slate-800 mb-2">Security</h4>
                        <p class="text-slate-500 text-sm">2FA is enabled for your account.</p>
                    </div>
                </div>

                @php
                    $myEmployee = \App\Models\Employee::where('email', Auth::user()->email)->first();
                    $deptName = $myEmployee && $myEmployee->department ? $myEmployee->department->name : 'No Dept';
                @endphp
                <div class="group block bg-white overflow-hidden shadow-sm rounded-2xl border border-slate-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="p-6">
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center text-purple-600 mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <h4 class="text-lg font-bold text-slate-800 mb-2">{{ $deptName }}</h4>
                        <p class="text-slate-500 text-sm">Your assigned department.</p>
                    </div>
                </div>
            </div>

            @if($myEmployee && $myEmployee->department_id)
                <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-slate-200 animate-fade-in-up delay-300">
                    <div class="p-6 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-slate-800">My Team: {{ $deptName }}</h3>
                        <span class="text-xs font-bold text-blue-600 bg-blue-100 px-2 py-1 rounded">
                            {{ \App\Models\Employee::where('department_id', $myEmployee->department_id)->count() }} Members
                        </span>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach(\App\Models\Employee::where('department_id', $myEmployee->department_id)->get() as $colleague)
                                <div class="flex items-center space-x-3 p-3 rounded-lg border border-slate-100 hover:bg-slate-50 transition">
                                    <div class="h-10 w-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                        {{ substr($colleague->first_name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-800">{{ $colleague->first_name }} {{ $colleague->last_name }}</p>
                                        <p class="text-xs text-slate-500">{{ $colleague->job_title }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>