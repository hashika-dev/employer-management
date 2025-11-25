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
            
            /* Custom Animation Keyframes */
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

            /* Animation Classes */
            .animate-fade-in-up { animation: fade-in-up 0.8s ease-out forwards; }
            .animate-fade-in-right { animation: fade-in-right 0.8s ease-out forwards; }
            .animate-fade-in-down { animation: fade-in-down 0.8s ease-out forwards; }
            
            /* Delay utilities */
            .delay-100 { animation-delay: 0.1s; }
            .delay-200 { animation-delay: 0.2s; }
            .delay-300 { animation-delay: 0.3s; }
            .delay-500 { animation-delay: 0.5s; }

            /* Initial state for scroll animations */
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
                            <a href="{{ route('login') }}" class="text-slate-600 hover:text-blue-600 font-semibold px-4 transition">Log In</a>
                            <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-6 rounded-lg transition shadow-md hover:shadow-blue-500/30">
                                Get Started
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
                        
                        <div class="delay-200 animate-fade-in-up">
                            <p class="text-sm font-semibold text-slate-400 uppercase tracking-wider mb-4">Trusted by modern companies</p>
                            <div class="flex flex-wrap gap-8 items-center opacity-60 grayscale transition hover:grayscale-0 hover:opacity-100">
                                <svg class="h-8" viewBox="0 0 125 35" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.25 24.5C18.8774 24.5 24.25 19.1274 24.25 12.5C24.25 5.87258 18.8774 0.5 12.25 0.5C5.62258 0.5 0.25 5.87258 0.25 12.5C0.25 19.1274 5.62258 24.5 12.25 24.5Z" fill="#A0AEC0"/><path d="M100.25 24.5C106.877 24.5 112.25 19.1274 112.25 12.5C112.25 5.87258 106.877 0.5 100.25 0.5C93.6226 0.5 88.25 5.87258 88.25 12.5C88.25 19.1274 93.6226 24.5 100.25 24.5Z" fill="#A0AEC0"/><path d="M56.25 24.5C62.8774 24.5 68.25 19.1274 68.25 12.5C68.25 5.87258 62.8774 0.5 56.25 0.5C49.6226 0.5 44.25 5.87258 44.25 12.5C44.25 19.1274 49.6226 24.5 56.25 24.5Z" fill="#A0AEC0"/></svg>
                                <svg class="h-6" viewBox="0 0 98 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="24" height="24" rx="4" fill="#A0AEC0"/><rect x="37" width="24" height="24" rx="4" fill="#A0AEC0"/><rect x="74" width="24" height="24" rx="4" fill="#A0AEC0"/></svg>
                            </div>
                        </div>
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

                    <div class="flex space-x-6">
                        <a href="#" class="text-gray-400 hover:text-blue-600 transition transform hover:-translate-y-1">
                            <span class="sr-only">Facebook</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-pink-600 transition transform hover:-translate-y-1">
                            <span class="sr-only">Instagram</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12.315 2c2.43 0 2.733.01 3.733.056 1.009.045 1.877.232 2.633.525a5.36 5.36 0 0 1 1.932 1.258 5.36 5.36 0 0 1 1.258 1.932c.293.756.48 1.624.525 2.633.046 1.001.056 1.304.056 3.733s-.01 2.733-.056 3.733c-.045 1.009-.232 1.877-.525 2.633a5.36 5.36 0 0 1-1.258 1.932 5.36 5.36 0 0 1-1.932 1.258c-.756.293-1.624.48-2.633.525-1.001.046-1.304.056-3.733.056s-2.733-.01-3.733-.056c-1.009-.045-1.877-.232-2.633-.525a5.36 5.36 0 0 1-1.932-1.258 5.36 5.36 0 0 1-1.258-1.932c-.293-.756-.48-1.624-.525-2.633-.046-1.001-.056-1.304-.056-3.733s.01-2.733.056-3.733c.045-1.009.232-1.877.525-2.633a5.36 5.36 0 0 1 1.258-1.932 5.36 5.36 0 0 1 1.932-1.258c.756-.293 1.624-.48 2.633-.525 1.001-.046 1.304-.056 3.733-.056zm0 2.163c-2.43 0-2.733.01-3.733.056-1.009.045-1.877.232-2.633.525a3.19 3.19 0 0 0-1.162.754 3.19 3.19 0 0 0-.754 1.162c-.293.756-.48 1.624-.525 2.633-.046 1.001-.056 1.304-.056 3.733s.01 2.733.056 3.733c.045 1.009.232 1.877.525 2.633a3.19 3.19 0 0 0 .754 1.162 3.19 3.19 0 0 0 1.162.754c.756.293 1.624.48 2.633.525 1.001.046 1.304.056 3.733.056s2.733-.01 3.733-.056c1.009-.045 1.877-.232 2.633-.525a3.19 3.19 0 0 0 1.162-.754 3.19 3.19 0 0 0 .754-1.162c.293-.756.48-1.624.525-2.633.046-1.001.056-1.304.056-3.733s-.01-2.733-.056-3.733c-.045-1.009-.232-1.877-.525-2.633a3.19 3.19 0 0 0-.754-1.162 3.19 3.19 0 0 0-1.162-.754c-.756-.293-1.624-.48-2.633-.525-1.001-.046-1.304-.056-3.733-.056z"/><path d="M12.315 7.325a4.675 4.675 0 1 0 0 9.35 4.675 4.675 0 0 0 0-9.35zm0 7.187a2.512 2.512 0 1 1 0-5.024 2.512 2.512 0 0 1 0 5.024z"/><circle cx="17.25" cy="6.75" r="1.08"/></svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-black transition transform hover:-translate-y-1">
                            <span class="sr-only">TikTok</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/></svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-blue-700 transition transform hover:-translate-y-1">
                            <span class="sr-only">LinkedIn</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.761 0 5-2.239 5-5v-14c0-2.761-2.239-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-red-600 transition transform hover:-translate-y-1">
                            <span class="sr-only">Gmail</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                        </a>
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