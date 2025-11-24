<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>StaffFlow - Employee Portal</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="antialiased bg-gray-50 text-slate-800">

        <div class="relative flex items-center justify-center min-h-screen bg-gray-100 sm:items-center py-4 sm:pt-0">

            <div class="max-w-xl w-full mx-auto sm:px-6 lg:px-8 text-center">
                
                <!-- Logo (Same for everyone) -->
                <div class="flex justify-center mb-8">
                    <div class="h-20 w-20 bg-blue-600 rounded-2xl flex items-center justify-center shadow-xl">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Title -->
                <h1 class="text-5xl font-extrabold tracking-tight text-slate-900 mb-2">
                    StaffFlow
                </h1>
                <p class="text-lg text-gray-500 mb-10">
                    Employee Portal & HR System
                </p>

                <!-- USER BUTTONS (Login & Register) -->
                <div class="space-y-4">
                    @auth
                        <!-- If already logged in -->
                        <a href="{{ url('/dashboard') }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-8 rounded-xl shadow-lg transition transform hover:-translate-y-1">
                            Go to Dashboard
                        </a>
                    @else
                        <!-- User Login -->
                        <a href="{{ route('login') }}" class="block w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-4 px-8 rounded-xl shadow-lg transition transform hover:-translate-y-1">
                            Log In
                        </a>

                        <!-- User Register -->
                        <a href="{{ route('register') }}" class="block w-full bg-white hover:bg-gray-50 text-slate-700 font-bold py-4 px-8 rounded-xl border border-gray-300 shadow-sm transition">
                            Create New Account
                        </a>
                    @endauth
                </div>

                <!-- FOOTER (No Admin Link anymore) -->
                <div class="mt-12 text-xs text-gray-400">
                    &copy; {{ date('Y') }} StaffFlow Inc.
                </div>
            </div>
        </div>
    </body>
</html>