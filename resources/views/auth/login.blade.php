<x-guest-layout>
    <div class="min-h-screen flex">
        
        <div class="hidden lg:flex w-1/2 bg-slate-900 relative overflow-hidden items-center justify-center">
            <div class="absolute top-0 left-0 w-full h-full">
                <div class="absolute top-10 left-10 w-72 h-72 bg-blue-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
                <div class="absolute top-10 right-10 w-72 h-72 bg-purple-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
                <div class="absolute -bottom-8 left-20 w-72 h-72 bg-pink-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>
            </div>

            <div class="relative z-10 text-center px-12 animate-fade-in-up">
                <div class="h-20 w-20 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center mx-auto mb-8 shadow-2xl border border-white/20">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <h2 class="text-4xl font-bold text-white mb-4 tracking-tight">Staff Portal</h2>
                <p class="text-blue-200 text-lg leading-relaxed max-w-md mx-auto">
                    Manage your profile, view updates, and connect with your team.
                </p>
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center bg-white p-8 sm:p-12 lg:p-24">
            <div class="w-full max-w-md space-y-8 animate-fade-in-up delay-100">
                
                <div class="text-center lg:text-left">
                    <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                        Employee Login
                    </h2>
                    <p class="mt-2 text-sm text-gray-500">
                        Please sign in with your ID or Email.
                    </p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-6">
                    @csrf
                    
                    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

                    <div>
                        <label for="login_identifier" class="block text-sm font-medium text-gray-700">Employee ID or Email</label>
                        <div class="mt-1">
                            <input id="login_identifier" name="login_identifier" type="text" required autofocus 
                                class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-200 ease-in-out bg-gray-50 hover:bg-white"
                                value="{{ old('login_identifier') }}"
                                placeholder="e.g. EMP-2025-001">
                        </div>
                        <x-input-error :messages="$errors->get('login_identifier')" class="mt-2" />
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <div class="mt-1">
                            <input id="password" name="password" type="password" autocomplete="current-password" required 
                                class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-200 ease-in-out bg-gray-50 hover:bg-white">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex justify-center">
                        <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                    </div>
                    @error('g-recaptcha-response')
                        <p class="text-red-500 text-xs mt-1 text-center">{{ $message }}</p>
                    @enderror

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded transition duration-150 ease-in-out">
                            <label for="remember_me" class="ml-2 block text-sm text-gray-900">Remember me</label>
                        </div>

                        @if (Route::has('password.request'))
                            <div class="text-sm">
                                <a href="{{ route('password.request') }}" class="font-medium text-blue-600 hover:text-blue-500 transition duration-150 ease-in-out">
                                    Forgot password?
                                </a>
                            </div>
                        @endif
                    </div>

                    <div>
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200 ease-in-out transform hover:-translate-y-0.5">
                            Sign in
                        </button>
                    </div>
                </form>

             <!-- FULL PAGE ACCOUNT LOCKED MODAL -->


                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">Protected by StaffFlow Security</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div id="unlockModal"
     class="fixed inset-0 z-50 hidden flex items-center justify-center bg-gray-900 bg-opacity-60 backdrop-blur-sm">

    <!-- Modal Box -->
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">

        <div class="text-center">
            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-red-100 mb-4">
                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                    </path>
                </svg>
            </div>

            <h3 class="text-lg font-semibold text-gray-900">Account Locked</h3>
            <p class="text-sm text-gray-500 mt-2">
                You have exceeded the maximum login attempts. To unlock your account, verify your email and set a new password.
            </p>
        </div>

        <form method="POST" action="{{ route('account.unlock') }}" class="mt-6 space-y-4">
            @csrf

            <input type="hidden" id="unlock_email" name="email">

            <!-- STEP 1 -->
            <div id="step1">
                <button type="button" onclick="sendOtp()"
                        class="w-full rounded-md bg-blue-600 px-4 py-2 text-base text-white font-medium shadow-sm hover:bg-blue-700">
                    Send OTP to my Email
                </button>
                <p id="otp-message" class="text-xs text-center mt-2 text-green-600 hidden"></p>
            </div>

            <!-- STEP 2 -->
            <div id="step2" class="hidden space-y-4">
                <div>
                    
                    <label class="block text-sm font-medium text-gray-700">Enter OTP</label>
                    <input type="text" name="otp"
                           class="w-full mt-1 rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                           required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">New Password</label>
                    <input type="password" name="password"
                           class="w-full mt-1 rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                           required>
                    <p class="text-xs text-gray-400 mt-1">Min 8 chars, 1 Upper, 1 Number, 1 Underscore (_)</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input type="password" name="password_confirmation"
                           class="w-full mt-1 rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                           required>
                </div>

                <button type="submit"
                        class="w-full rounded-md bg-green-600 px-4 py-2 text-white font-medium hover:bg-green-700">
                    Unlock Account
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    @if($errors->has('login_identifier') && $errors->first('login_identifier') == 'account_locked')
        const loginInput = document.getElementById('login_identifier');
        if (loginInput) {
            document.getElementById('unlock_email').value = loginInput.value;
        }
        document.getElementById('unlockModal').classList.remove('hidden');
    @endif
});

function sendOtp() {
    const email = document.getElementById('unlock_email').value;
    const btn = event.target;

    btn.disabled = true;
    btn.innerText = "Sending...";

    fetch("{{ route('account.send-otp') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ email: email })
    })
    .then(res => res.json())
    .then(() => {
        document.getElementById('step1').classList.add('hidden');
        document.getElementById('step2').classList.remove('hidden');
        document.getElementById('otp-message').innerText = "OTP Sent! Check your inbox.";
        document.getElementById('otp-message').classList.remove('hidden');
    })
    .catch(() => {
        btn.disabled = false;
        btn.innerText = "Retry Sending OTP";
        alert("Error sending OTP. Please try again.");
    });
}
</script>

</x-guest-layout>