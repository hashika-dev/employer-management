<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'StaffFlow') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.tailwindcss.com"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <style>
            body { font-family: 'Inter', sans-serif; }
            [x-cloak] { display: none !important; }

            /* Smooth Entrance Animations */
            @keyframes slideInRight {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes fadeInUp {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }
            @keyframes scaleIn {
                from { opacity: 0; transform: scale(0.95); }
                to { opacity: 1; transform: scale(1); }
            }

            .animate-slide-in { animation: slideInRight 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
            .animate-fade-in-up { animation: fadeInUp 0.6s ease-out forwards; }
            .animate-scale-in { animation: scaleIn 0.3s ease-out forwards; }
            
            .delay-100 { animation-delay: 0.1s; }
            .delay-200 { animation-delay: 0.2s; }
            .delay-300 { animation-delay: 0.3s; }
        </style>
    </head>
    <body class="font-sans antialiased bg-slate-50 text-slate-800">
        <div class="min-h-screen flex flex-col">
            @include('layouts.navigation')

            @isset($header)
                <header class="bg-white shadow-sm border-b border-slate-100 relative z-10">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main class="flex-grow relative">
                {{ $slot }}
            </main>

            <div x-data="{ show: false, message: '', type: 'success' }"
                 x-init="@if(session('success')) message = '{{ session('success') }}'; type = 'success'; show = true; setTimeout(() => show = false, 4000); @elseif(session('error')) message = '{{ session('error') }}'; type = 'error'; show = true; setTimeout(() => show = false, 4000); @elseif(session('warning')) message = '{{ session('warning') }}'; type = 'warning'; show = true; setTimeout(() => show = false, 4000); @endif"
                 x-show="show"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 translate-y-2"
                 class="fixed bottom-5 right-5 z-50 flex items-center p-4 rounded-lg shadow-2xl min-w-[300px]"
                 :class="{
                    'bg-slate-900 text-white border-l-4 border-green-500': type === 'success',
                    'bg-red-600 text-white border-l-4 border-red-800': type === 'error',
                    'bg-yellow-500 text-white border-l-4 border-yellow-700': type === 'warning'
                 }"
                 style="display: none;">
                
                <div class="mr-3">
                    <template x-if="type === 'success'">
                        <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </template>
                    <template x-if="type === 'error'">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </template>
                    <template x-if="type === 'warning'">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </template>
                </div>

                <div>
                    <p class="font-bold text-sm" x-text="type === 'success' ? 'Success' : (type === 'error' ? 'Error' : 'Attention')"></p>
                    <p class="text-sm opacity-90" x-text="message"></p>
                </div>

                <button @click="show = false" class="ml-auto text-white hover:text-gray-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <footer class="bg-white border-t border-slate-200 mt-auto py-6">
                <div class="max-w-7xl mx-auto px-4 text-center text-slate-400 text-sm">
                    &copy; {{ date('Y') }} StaffFlow Systems. All rights reserved.
                </div>
            </footer>
        </div>
    </body>
</html>