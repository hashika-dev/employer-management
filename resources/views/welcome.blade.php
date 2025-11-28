<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>StaffFlow - Modern Workforce Management</title>
        
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
        
        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            body { font-family: 'Inter', sans-serif; }
            
            @keyframes fade-in-up {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }
            @keyframes fade-in-right {
                from { opacity: 0; transform: translateX(30px); }
                to { opacity: 1; transform: translateX(0); }
            }
            @keyframes fade-in-down {
                from { opacity: 0; transform: translateY(-20px); }
                to { opacity: 1; transform: translateY(0); }
            }

            .animate-fade-in-up { animation: fade-in-up 0.8s ease-out forwards; }
            .animate-fade-in-right { animation: fade-in-right 0.8s ease-out forwards; }
            .animate-fade-in-down { animation: fade-in-down 0.8s ease-out forwards; }
            
            .delay-100 { animation-delay: 0.1s; }
            .delay-200 { animation-delay: 0.2s; }
            .delay-300 { animation-delay: 0.3s; }
            .scroll-trigger { opacity: 0; }
        </style>
    </head>
    <body class="antialiased bg-white text-slate-800 overflow-x-hidden">

        <nav class="fixed w-full z-50 top-0 bg-white/90 backdrop-blur-md border-b border-gray-100 animate-fade-in-down">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20 items-center">
                    
                    <div class="flex items-center">
                        <div class="h-10 w-10 bg-blue-600 rounded-lg flex items-center justify-center mr-3 shadow-sm">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <span class="font-bold text-2xl tracking-tight text-slate-900">StaffFlow</span>
                    </div>

                    <div class="flex items-center space-x-3">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-blue-600 font-bold hover:underline transition">Go to Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-6 rounded-lg transition shadow-md hover:shadow-blue-500/30">
                                Log In
                            </a>
                            @endauth
                    </div>
                </div>
            </div>
        </nav>

        <div class="relative pt-36 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                    
                    <div class="animate-fade-in-up">
                        <h1 class="text-5xl lg:text-6xl font-extrabold text-slate-900 leading-tight mb-6">
                            Make work <br>
                            <span class="text-blue-600 inline-block">easy again.</span>
                        </h1>
                        <p class="text-lg text-slate-500 mb-10 max-w-lg leading-relaxed delay-100 animate-fade-in-up">
                            The intelligent workforce management platform designed to help teams connect, collaborate, and grow. Manage your staff with confidence.
                        </p>
                    </div>

                    <div class="relative animate-fade-in-right delay-300">
                        <div class="absolute -inset-4 bg-gradient-to-tr from-blue-100 to-purple-50 rounded-3xl blur-3xl opacity-50"></div>
                        <img src="https://images.unsplash.com/photo-1497215728101-856f4ea42174?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80" alt="Office Dashboard" class="relative rounded-2xl shadow-2xl border border-gray-100/50 transform transition duration-700 hover:scale-[1.02] hover:shadow-blue-100">
                    </div>

                </div>
            </div>
        </div>

        <div class="bg-slate-50 py-24" id="features">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16 scroll-trigger">
                    <h2 class="text-sm font-bold text-blue-600 tracking-widest uppercase mb-2">Why StaffFlow?</h2>
                    <p class="text-3xl leading-8 font-extrabold tracking-tight text-slate-900 sm:text-4xl">
                        Everything you need to manage your team.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100/50 hover:shadow-md transition-all duration-300 hover:-translate-y-1 scroll-trigger delay-100">
                        <div class="h-14 w-14 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center mb-6 shadow-sm">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">Employee Directory</h3>
                        <p class="text-slate-500 leading-relaxed">Keep track of your entire workforce in one secure, searchable database. Access profiles instantly.</p>
                    </div>

                    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100/50 hover:shadow-md transition-all duration-300 hover:-translate-y-1 scroll-trigger delay-200">
                        <div class="h-14 w-14 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center mb-6 shadow-sm">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">Secure Access</h3>
                        <p class="text-slate-500 leading-relaxed">Enterprise-grade security with 2-Factor Authentication and reCAPTCHA protection built-in.</p>
                    </div>

                    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100/50 hover:shadow-md transition-all duration-300 hover:-translate-y-1 scroll-trigger delay-300">
                        <div class="h-14 w-14 bg-green-100 text-green-600 rounded-xl flex items-center justify-center mb-6 shadow-sm">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">API Integration</h3>
                        <p class="text-slate-500 leading-relaxed">Connect with external tools and mobile apps using our robust JSON API for seamless data sync.</p>
                    </div>
                </div>
            </div>
        </div>

        <footer class="bg-white border-t border-gray-100 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                 <div class="flex flex-col md:flex-row justify-between items-center gap-8">
                    <div class="flex items-center space-x-2">
                        <span class="font-bold text-xl tracking-tight text-slate-900">StaffFlow</span>
                        <span class="text-gray-400 text-sm">© {{ date('Y') }}</span>
                    </div>
                </div>
            </div>
        </footer>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const triggers = document.querySelectorAll('.scroll-trigger');
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('animate-fade-in-up');
                            entry.target.classList.remove('scroll-trigger', 'opacity-0');
                        }
                    });
                }, { threshold: 0.2 });
                triggers.forEach(trigger => observer.observe(trigger));
            });
        </script>

    </body>
</html>