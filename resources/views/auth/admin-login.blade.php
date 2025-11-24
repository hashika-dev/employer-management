<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>StaffFlow - Admin Access</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="antialiased bg-gray-50 text-slate-800">

        <div class="relative flex items-center justify-center min-h-screen bg-gray-100 sm:items-center py-4 sm:pt-0">

            <div class="max-w-md w-full mx-auto sm:px-6 lg:px-8 text-center">
                
                <!-- Logo (Same as User) -->
                <div class="flex justify-center mb-8">
                    <div class="h-20 w-20 bg-slate-800 rounded-2xl flex items-center justify-center shadow-xl">
                        <!-- Note: Logo is Dark for Admin distinction -->
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Title -->
                <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 mb-2">
                    Admin Panel
                </h1>
                <p class="text-sm text-gray-500 mb-8">
                    Secure Access Only
                </p>

                <!-- ADMIN LOGIN FORM (Same container style as user buttons) -->
                <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-200 text-left">
                    
                    <form method="POST" action="{{ route('admin.login.submit') }}">
                        @csrf

                        <!-- Email -->
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Email Address</label>
                            <input type="email" name="email" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-300 focus:border-slate-500 focus:bg-white focus:ring-0" required autofocus>
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                            <input type="password" name="password" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-300 focus:border-slate-500 focus:bg-white focus:ring-0" required>
                        </div>

                        <!-- reCAPTCHA (Optional - Keep if you want) -->
                        <!-- <div class="g-recaptcha mb-4" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div> -->

                        <!-- Submit Button -->
                        <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-3 rounded-lg transition transform hover:-translate-y-1 shadow-md">
                            Secure Login
                        </button>
                    </form>

                </div>

                <!-- Footer -->
                <div class="mt-8 text-xs text-gray-400">
                    &copy; {{ date('Y') }} StaffFlow Inc.
                </div>
            </div>
        </div>
    </body>
</html>