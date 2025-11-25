<x-guest-layout>
    <div class="min-h-screen flex">
        
        <!-- LEFT SIDE: SECURITY BRANDING -->
        <div class="hidden lg:flex w-1/2 bg-slate-900 relative overflow-hidden items-center justify-center">
            <!-- Abstract Background Shapes -->
            <div class="absolute top-0 left-0 w-full h-full">
                <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-blue-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
                <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-emerald-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
            </div>

            <!-- Content -->
            <div class="relative z-10 text-center px-12 animate-fade-in-up">
                <div class="h-24 w-24 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center mx-auto mb-8 shadow-2xl border border-white/20">
                    <!-- Shield Icon -->
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-white mb-4 tracking-tight">Identity Verification</h2>
                <p class="text-slate-300 text-lg leading-relaxed max-w-md mx-auto">
                    "Security is not just a feature, it's a promise." <br> We are keeping your account safe.
                </p>
            </div>
        </div>

        <!-- RIGHT SIDE: FORM -->
        <div class="w-full lg:w-1/2 flex items-center justify-center bg-white p-8 sm:p-12 lg:p-24">
            <div class="w-full max-w-md space-y-8 animate-fade-in-up delay-100">
                
                <div class="text-center lg:text-left">
                    <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                        Two-Factor Authentication
                    </h2>
                    <p class="mt-2 text-sm text-gray-500">
                        Please enter the 6-digit code sent to your email.
                    </p>
                </div>

                <!-- Success Message -->
                @if (session('message'))
                    <div class="rounded-md bg-green-50 p-4 border border-green-200">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800">{{ session('message') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Error Message -->
                @if ($errors->any())
                    <div class="rounded-md bg-red-50 p-4 border border-red-200">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-red-800">{{ $errors->first() }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('verify.store') }}" class="mt-8 space-y-6">
                    @csrf

                    <div>
                        <label for="two_factor_code" class="block text-sm font-medium text-gray-700">Verification Code</label>
                        <div class="mt-1">
                            <input id="two_factor_code" name="two_factor_code" type="text" required autofocus 
                                class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-center text-2xl tracking-widest font-mono bg-gray-50 hover:bg-white transition"
                                placeholder="000000" maxlength="6">
                        </div>
                    </div>

                    <div class="flex flex-col space-y-4">
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-slate-900 hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-900 transition duration-200 ease-in-out transform hover:-translate-y-0.5">
                            Verify Identity
                        </button>
                        
                        <div class="text-center">
                            <span class="text-sm text-gray-500">Didn't receive the code?</span>
                            <a href="{{ route('verify.resend') }}" class="font-medium text-sm text-blue-600 hover:text-blue-500 transition">
                                Resend Email
                            </a>
                        </div>
                    </div>
                </form>

                <!-- Footer Help -->
                <div class="mt-6 border-t border-gray-100 pt-6 text-center">
                    <p class="text-xs text-gray-400">
                        Secure Connection • StaffFlow Inc.
                    </p>
                </div>

            </div>
        </div>
    </div>
</x-guest-layout>