<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            
            {{-- LEFT SIDE: LOGO & LINKS --}}
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}">
                            <h1 class="text-slate-800 font-extrabold text-xl tracking-wider">HR MANAGER</h1>
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}">
                            <h1 class="text-blue-600 font-bold text-xl tracking-wider">STAFF PORTAL</h1>
                        </a>
                    @endif
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @if(Auth::user()->role === 'admin')
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.employees.index')" :active="request()->routeIs('admin.employees.*')">
                            {{ __('Staff Directory') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.attendance.index')" :active="request()->routeIs('admin.attendance.*')">
                            {{ __('Attendance Log') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.departments.index')" :active="request()->routeIs('admin.departments.*')">
                            {{ __('Departments') }}
                        </x-nav-link>
                    @else
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('My Dashboard') }}
                        </x-nav-link>
                        
                        {{-- Added Task Manager Link from previous steps --}}
                        @if(Route::has('tasks.index'))
                            <x-nav-link :href="route('tasks.index')" :active="request()->routeIs('tasks.*')">
                                {{ __('My Tasks') }}
                            </x-nav-link>
                        @endif
                    @endif
                </div>
            </div>

            {{-- RIGHT SIDE: PROFILE & LOGOUT ICONS --}}
            <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-3">
                
                {{-- 1. Profile Picture / Initials Icon --}}
                <a href="{{ route('profile.edit') }}" 
                   class="relative flex items-center justify-center w-10 h-10 rounded-full bg-indigo-600 text-white font-bold hover:ring-4 hover:ring-indigo-100 transition overflow-hidden shadow-sm group"
                   title="View Profile">
                    
                    @if(Auth::user()->profile_photo_path)
                        {{-- Show Uploaded Photo --}}
                        <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" 
                             alt="{{ Auth::user()->first_name }}" 
                             class="w-full h-full object-cover">
                    @else
                        {{-- Show Initials (Acronym) --}}
                        <span class="text-sm group-hover:scale-110 transition-transform duration-200">
                            {{ substr(Auth::user()->first_name, 0, 1) }}{{ substr(Auth::user()->last_name, 0, 1) }}
                        </span>
                    @endif
                </a>

                {{-- 2. Logout Icon --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" 
                            class="p-2 text-slate-400 hover:text-red-600 transition rounded-full hover:bg-red-50 focus:outline-none" 
                            title="Log Out">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                    </button>
                </form>

            </div>

            {{-- Hamburger Menu (Mobile) --}}
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @if(Auth::user()->role === 'admin')
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.employees.index')" :active="request()->routeIs('admin.employees.*')">
                    {{ __('Staff Directory') }}
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('My Dashboard') }}
                </x-responsive-nav-link>
            @endif
        </div>

        {{-- Mobile User Settings --}}
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4 flex items-center">
                <div class="flex-shrink-0 mr-3">
                     <div class="h-10 w-10 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold overflow-hidden">
                        @if(Auth::user()->profile_photo_path)
                            <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" class="w-full h-full object-cover">
                        @else
                            {{ substr(Auth::user()->first_name, 0, 1) }}{{ substr(Auth::user()->last_name, 0, 1) }}
                        @endif
                     </div>
                </div>
                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>