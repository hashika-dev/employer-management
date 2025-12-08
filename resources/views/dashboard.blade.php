<x-app-layout>
    
    {{-- ========================================== --}}
    {{-- START: POPUP LOGIC (Only for New Users)    --}}
    {{-- ========================================== --}}
    @if(Auth::user()->is_setup == 0)
        <div style="position: fixed; inset: 0; background-color: rgba(15, 23, 42, 0.9); z-index: 9999; display: flex; justify-content: center; align-items: center; backdrop-filter: blur(5px);">
            
            <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-lg w-full mx-4 relative transform" style="animation: popIn 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);">
                
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-yellow-100 mb-6">
                        <svg class="h-8 w-8 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>

                    <h3 class="text-2xl font-bold text-slate-800 mb-2">Profile Setup Required</h3>
                    <p class="text-slate-500 mb-8">
                        Welcome, {{ Auth::user()->name }}! To access all features and view your team, please complete your employee profile setup.
                    </p>

                    <a href="{{ route('profile.edit') }}" class="block w-full py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-lg transition duration-200 transform hover:-translate-y-1">
                        Go to Profile Setup &rarr;
                    </a>
                </div>
            </div>
        </div>

        <style>
            @keyframes popIn {
                0% { opacity: 0; transform: scale(0.5); }
                100% { opacity: 1; transform: scale(1); }
            }
        </style>
    @endif
    {{-- END POPUP LOGIC --}}


    <x-slot name="header">
        <div class="flex justify-between items-center">
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
            
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-slate-200 p-6 animate-fade-in-up">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Attendance</h3>
                        <p class="text-sm text-slate-500">{{ now()->format('l, F j, Y') }}</p>
                    </div>
                    
                    <div>
                        @php
                            $todayAttendance = \App\Models\Attendance::where('user_id', Auth::id())
                                ->where('date', \Carbon\Carbon::today())
                                ->first();
                        @endphp

                        @if(!$todayAttendance)
                            <form action="{{ route('attendance.timein') }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition transform hover:-translate-y-0.5">
                                    🕒 Time In
                                </button>
                            </form>
                        @elseif(!$todayAttendance->time_out)
                            <div class="flex items-center gap-4">
                                <span class="text-sm font-mono text-gray-600">Started: {{ \Carbon\Carbon::parse($todayAttendance->time_in)->format('h:i A') }}</span>
                                
                                {{-- ==================================================== --}}
                                {{-- MODIFIED: Time Out Form with ID & Button Type Change --}}
                                {{-- ==================================================== --}}
                                <form id="timeout-form" action="{{ route('attendance.timeout') }}" method="POST">
                                    @csrf
                                    <button type="button" onclick="openTimeoutModal()" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition transform hover:-translate-y-0.5">
                                        🛑 Time Out
                                    </button>
                                </form>
                                {{-- ==================================================== --}}

                            </div>
                        @else
                            <div class="text-green-700 bg-green-100 px-4 py-2 rounded-lg font-bold text-sm border border-green-200">
                                ✅ Attendance Complete ({{ \Carbon\Carbon::parse($todayAttendance->time_in)->format('h:i A') }} - {{ \Carbon\Carbon::parse($todayAttendance->time_out)->format('h:i A') }})
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                {{-- Card 1: Account Status --}}
                <div class="group block bg-white overflow-hidden shadow-sm rounded-2xl border border-slate-100 hover:shadow-xl transition-all duration-300">
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

                {{-- Card 2: Security --}}
                <div class="group block bg-white overflow-hidden shadow-sm rounded-2xl border border-slate-100 hover:shadow-xl transition-all duration-300">
                    <div class="p-6">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center text-green-600 mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <h4 class="text-lg font-bold text-slate-800 mb-2">Security</h4>
                        <p class="text-slate-500 text-sm">2FA is enabled for your account.</p>
                    </div>
                </div>

                {{-- Card 3: Department (UPDATED LOGIC) --}}
                <div class="group block bg-white overflow-hidden shadow-sm rounded-2xl border border-slate-100 hover:shadow-xl transition-all duration-300">
                    <div class="p-6">
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center text-purple-600 mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        {{-- DIRECTLY USE AUTH USER DEPARTMENT --}}
                        <h4 class="text-lg font-bold text-slate-800 mb-2">
                            {{ Auth::user()->department ? Auth::user()->department->name : 'No Department' }}
                        </h4>
                        <p class="text-slate-500 text-sm">Your assigned department.</p>
                    </div>
                </div>
            </div>

            {{-- Team Section (UPDATED LOGIC) --}}
            @if(Auth::user()->department_id)
                <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-slate-200 mt-8">
                    <div class="p-6 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-slate-800">My Team: {{ Auth::user()->department->name }}</h3>
                        <span class="text-xs font-bold text-blue-600 bg-blue-100 px-2 py-1 rounded">
                            {{-- Count other users in same department --}}
                            {{ \App\Models\User::where('department_id', Auth::user()->department_id)->count() }} Members
                        </span>
                    </div>
                    
                    <div class="p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            {{-- Loop through USERS, not Employees --}}
                            @foreach(\App\Models\User::where('department_id', Auth::user()->department_id)->get() as $colleague)
                                <div class="flex items-center space-x-3 p-3 rounded-lg border border-slate-100 hover:bg-slate-50 transition">
                                    <div class="h-10 w-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center text-white font-bold text-sm overflow-hidden">
                                        @if($colleague->profile_photo_path)
                                            <img src="{{ asset('storage/' . $colleague->profile_photo_path) }}" class="w-full h-full object-cover">
                                        @else
                                            {{ substr($colleague->first_name, 0, 1) }}
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-800">{{ $colleague->first_name }} {{ $colleague->last_name }}</p>
                                        <p class="text-xs text-slate-500">{{ $colleague->job_title ?? 'Staff' }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>

    {{-- ========================================== --}}
    {{-- ADDED: TIMEOUT CONFIRMATION MODAL & SCRIPT --}}
    {{-- ========================================== --}}
    
    <div id="timeoutModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity backdrop-blur-sm" onclick="closeTimeoutModal()"></div>

        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                <h3 class="text-lg font-semibold leading-6 text-gray-900" id="modal-title">Clock Out Confirmation</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Are you sure you want to end your shift? This action will log your current time as your clock-out time.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button type="button" onclick="document.getElementById('timeout-form').submit()" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">
                            Yes, Clock Out
                        </button>
                        <button type="button" onclick="closeTimeoutModal()" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openTimeoutModal() {
            document.getElementById('timeoutModal').classList.remove('hidden');
        }

        function closeTimeoutModal() {
            document.getElementById('timeoutModal').classList.add('hidden');
        }
    </script>

</x-app-layout>