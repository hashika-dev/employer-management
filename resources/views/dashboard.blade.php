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
                        Welcome to your workspace. Please ensure your profile information is up to date for HR records.
                    </p>
                    
                    <div class="mt-8 flex space-x-4">
                        <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-bold rounded-lg text-slate-900 bg-white hover:bg-blue-50 transition shadow-lg">
                            Edit My Details
                        </a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 animate-fade-in-up delay-200">
                <a href="{{ route('profile.edit') }}" class="group block bg-white overflow-hidden shadow-sm rounded-2xl border border-slate-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="p-6">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <h4 class="text-lg font-bold text-slate-800 mb-2">Personal Info</h4>
                        <p class="text-slate-500 text-sm">Update your address, phone, and emergency contacts.</p>
                    </div>
                </a>

                <div class="group block bg-white overflow-hidden shadow-sm rounded-2xl border border-slate-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="p-6">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center text-green-600 mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <h4 class="text-lg font-bold text-slate-800 mb-2">Security</h4>
                        <p class="text-slate-500 text-sm">Your account is secured with Two-Factor Authentication.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>