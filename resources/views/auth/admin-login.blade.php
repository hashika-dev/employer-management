<x-guest-layout>
    <div class="min-h-screen flex flex-col justify-center items-center bg-[#0f172a] relative overflow-hidden font-sans">
        
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0">
            <div class="absolute top-[-20%] left-[-10%] w-[500px] h-[500px] bg-blue-600/30 rounded-full mix-blend-screen filter blur-[100px] animate-blob"></div>
            <div class="absolute bottom-[-20%] right-[-10%] w-[500px] h-[500px] bg-indigo-600/30 rounded-full mix-blend-screen filter blur-[100px] animate-blob animation-delay-2000"></div>
            <div class="absolute top-[40%] left-[30%] w-[300px] h-[300px] bg-purple-600/20 rounded-full mix-blend-screen filter blur-[80px] animate-blob animation-delay-4000"></div>
        </div>

        <div class="relative z-10 w-full max-w-md px-6">
            
            <div class="text-center mb-8 animate-fade-in-down">
                <div class="mx-auto h-20 w-20 bg-white/5 border border-white/10 rounded-3xl flex items-center justify-center shadow-2xl mb-6 backdrop-blur-md group hover:bg-white/10 transition-all duration-500">
                    <svg class="w-10 h-10 text-blue-400 group-hover:scale-110 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h2 class="text-4xl font-extrabold text-white tracking-tight mb-2 drop-shadow-lg">Admin Portal</h2>
                <div class="flex items-center justify-center gap-2 text-blue-200/80 text-sm font-medium">
                    <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                    Secure System Access
                </div>
            </div>

            <div class="bg-white/10 backdrop-blur-xl border border-white/20 rounded-3xl shadow-2xl overflow-hidden animate-fade-in-up delay-100">
                <div class="p-8 sm:p-10">
                    
                    <x-auth-session-status class="mb-6" :status="session('status')" />

                    @if ($errors->any())
                        <div class="mb-6 bg-red-500/10 border border-red-500/50 rounded-xl p-4 flex items-start gap-3 animate-shake">
                            <svg class="w-5 h-5 text-red-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <div class="text-sm text-red-200">
                                <p class="font-bold text-red-100">Access Denied</p>
                                <p>{{ $errors->first() }}</p>
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-6">
                        @csrf
                        <script src="https://www.google.com/recaptcha/api.js" async defer></script>

                        <div class="group">
                            <label class="block text-xs font-bold text-blue-200 uppercase tracking-wider mb-2 ml-1">Administrator Email</label>
                            <div class="relative transition-all duration-300 focus-within:scale-[1.02]">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-blue-300/50 group-focus-within:text-blue-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                                </div>
                                <input id="login_identifier" name="login_identifier" type="text" required autofocus 
                                    class="block w-full pl-11 pr-4 py-3.5 bg-slate-800/50 border border-slate-600/50 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:bg-slate-800/80 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all duration-300 sm:text-sm" 
                                    placeholder="admin@company.com"
                                    value="{{ old('login_identifier') }}">
                            </div>
                        </div>

                        <div class="group">
                            <label class="block text-xs font-bold text-blue-200 uppercase tracking-wider mb-2 ml-1">Password</label>
                            <div class="relative transition-all duration-300 focus-within:scale-[1.02]">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-blue-300/50 group-focus-within:text-blue-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                </div>
                                <input id="password" name="password" type="password" required autocomplete="current-password"
                                    class="block w-full pl-11 pr-4 py-3.5 bg-slate-800/50 border border-slate-600/50 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:bg-slate-800/80 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all duration-300 sm:text-sm"
                                    placeholder="••••••••">
                            </div>
                        </div>

                        <div class="flex justify-center py-2 transform scale-90 sm:scale-100 transition-transform">
                            <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}" data-theme="dark"></div>
                        </div>
                        @error('g-recaptcha-response')
                            <span class="text-red-400 text-xs block text-center font-medium bg-red-900/20 py-1 rounded">{{ $message }}</span>
                        @enderror

                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input id="remember_me" name="remember" type="checkbox" 
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-slate-600 rounded bg-slate-700/50 cursor-pointer transition-colors">
                                <label for="remember_me" class="ml-2 block text-sm text-slate-300 cursor-pointer hover:text-white transition-colors">Remember me</label>
                            </div>
                        </div>

                        <button type="submit" class="w-full relative group overflow-hidden rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 p-[1px] focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 focus:ring-offset-slate-900 transition-transform duration-300 active:scale-[0.98]">
                            <span class="absolute inset-[-1000%] animate-[spin_2s_linear_infinite] bg-[conic-gradient(from_90deg_at_50%_50%,#E2E8F0_0%,#3B82F6_50%,#E2E8F0_100%)] opacity-0 group-hover:opacity-30 transition-opacity duration-300"></span>
                            <span class="relative flex items-center justify-center w-full h-full bg-slate-900 group-hover:bg-opacity-90 rounded-xl py-3.5 px-4 transition-all duration-300">
                                <span class="text-sm font-bold text-white tracking-wide uppercase group-hover:tracking-wider transition-all duration-300">Authenticate</span>
                                <svg class="ml-2 w-4 h-4 text-white group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </span>
                        </button>
                    </form>
                </div>
                
               
            </div>

            <div class="mt-8 text-center animate-fade-in-up delay-200">
                <p class="text-xs text-slate-500 font-mono">
                    System ID: <span class="text-slate-400">NODE-01</span> • Security Level: <span class="text-green-500">MAXIMUM</span>
                </p>
            </div>

        </div>
    </div>

    <style>
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-4px); }
            20%, 40%, 60%, 80% { transform: translateX(4px); }
        }
        .animate-shake {
            animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
        }
        .animate-fade-in-down {
            animation: fadeInDown 0.8s ease-out forwards;
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
        }
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
    </style>
</x-guest-layout>