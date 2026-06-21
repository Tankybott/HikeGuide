<nav x-data="{ open: false }" class="bg-white border-b border-gray-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            <div class="flex items-center gap-8">
                <a href="/" class="text-xl font-bold text-orange-600 tracking-tight">HikeGuide</a>
                <div class="hidden sm:flex items-center gap-6">
                    <a href="{{ route('regions.index') }}" class="text-sm font-medium text-gray-600 hover:text-orange-600 transition-colors">Regions</a>
                    <a href="{{ route('hikes.index') }}" class="text-sm font-medium text-gray-600 hover:text-orange-600 transition-colors">Hikes</a>
                </div>
            </div>

            <div class="hidden sm:flex items-center gap-3">
                @auth
                    @if(Auth::user()->is_admin)
                        <div x-data="{ adminOpen: false }" class="relative">
                            <button @click="adminOpen = !adminOpen" class="flex items-center gap-1.5 text-sm font-medium text-gray-700 hover:text-orange-600 transition-colors">
                                Admin Panel
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div
                                x-show="adminOpen"
                                @click.outside="adminOpen = false"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-44 bg-white rounded-lg shadow-lg border border-gray-100 py-1 z-50"
                            >
                                <a href="{{ route('admin.regions.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-colors">
                                    Regions
                                </a>
                                <a href="{{ route('admin.hikes.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-colors">
                                    Hikes
                                </a>
                                <a href="{{ route('admin.drafts.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-colors">
                                    Drafts
                                </a>
                                <a href="{{ route('admin.users.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-colors">
                                    Users
                                </a>
                            </div>
                        </div>
                    @endif
                    <div x-data="{ dropOpen: false }" class="relative">
                        <button @click="dropOpen = !dropOpen" class="flex items-center gap-1.5 text-sm font-medium text-gray-700 hover:text-orange-600 transition-colors">
                            {{ Auth::user()->nickname }}
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div
                            x-show="dropOpen"
                            @click.outside="dropOpen = false"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-44 bg-white rounded-lg shadow-lg border border-gray-100 py-1 z-50"
                        >
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-colors">
                                Profile
                            </a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-colors">
                                    Log out
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-orange-600 transition-colors">
                        Log in
                    </a>
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white text-sm font-semibold rounded-lg transition-colors">
                        Register
                    </a>
                @endauth
            </div>

            <button @click="open = !open" class="sm:hidden p-2 rounded-md text-gray-500 hover:text-orange-600 hover:bg-gray-100 transition-colors">
                <svg x-show="!open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg x-show="open" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

        </div>
    </div>

    <div
        x-show="open"
        x-cloak
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="opacity-0 -translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        class="sm:hidden border-t border-gray-100 bg-white"
    >
        <div class="px-4 py-3 space-y-1">
            <a href="{{ route('regions.index') }}" class="block py-2 text-sm font-medium text-gray-600 hover:text-orange-600 transition-colors">Regions</a>
            <a href="{{ route('hikes.index') }}" class="block py-2 text-sm font-medium text-gray-600 hover:text-orange-600 transition-colors">Hikes</a>
        </div>

        @auth
            <div class="px-4 py-3 border-t border-gray-100 space-y-1">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">{{ Auth::user()->nickname }}</p>
                <a href="{{ route('profile.edit') }}" class="block py-2 text-sm font-medium text-gray-600 hover:text-orange-600 transition-colors">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block py-2 text-sm font-medium text-gray-600 hover:text-orange-600 transition-colors">
                        Log out
                    </button>
                </form>
                @if(Auth::user()->is_admin)
                    <div class="border-t border-gray-100 my-1"></div>
                    <p class="text-xs font-semibold text-orange-400 uppercase tracking-wider mb-1">Admin Panel</p>
                    <a href="{{ route('admin.regions.index') }}" class="block py-2 text-sm font-medium text-gray-600 hover:text-orange-600 transition-colors pl-2">Regions</a>
                    <a href="{{ route('admin.hikes.index') }}" class="block py-2 text-sm font-medium text-gray-600 hover:text-orange-600 transition-colors pl-2">Hikes</a>
                    <a href="{{ route('admin.drafts.index') }}" class="block py-2 text-sm font-medium text-gray-600 hover:text-orange-600 transition-colors pl-2">Drafts</a>
                    <a href="{{ route('admin.users.index') }}" class="block py-2 text-sm font-medium text-gray-600 hover:text-orange-600 transition-colors pl-2">Users</a>
                @endif
            </div>
        @else
            <div class="px-4 py-3 border-t border-gray-100 space-y-2">
                <a href="{{ route('login') }}" class="block py-2 text-sm font-medium text-gray-600 hover:text-orange-600 transition-colors">Log in</a>
                <a href="{{ route('register') }}" class="block py-2 text-sm font-semibold text-orange-600 hover:text-orange-700 transition-colors">Register</a>
            </div>
        @endauth
    </div>
</nav>
