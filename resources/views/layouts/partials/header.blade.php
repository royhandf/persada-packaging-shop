<header class="bg-white/70 backdrop-blur-lg sticky top-0 z-20 border-b border-gray-200">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center gap-3">
                <button @click.stop="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none lg:hidden">
                    <x-heroicon-o-bars-3 class="h-6 w-6" />
                </button>
            </div>

            <div class="flex items-center gap-4 sm:gap-5">
                <button class="text-gray-500 hover:text-persada-primary">
                    <x-heroicon-o-sun class="w-6 h-6" />
                </button>

                <button class="relative text-gray-500 hover:text-persada-primary">
                    <x-heroicon-o-bell class="w-6 h-6" />
                    <span class="absolute -top-1 -right-1 h-2 w-2 bg-red-500 rounded-full"></span>
                </button>

                <div class="h-7 w-px bg-gray-200 hidden sm:block"></div>

                <div x-data="{ profileDropdownOpen: false }" class="relative">
                    <button @click="profileDropdownOpen = !profileDropdownOpen" class="flex items-center gap-3">
                        <img class="h-9 w-9 rounded-full object-cover"
                            src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=dcfce7&color=16a3a"
                            alt="User avatar">
                        <div class="hidden md:block text-left">
                            <p class="text-sm font-medium text-gray-800 truncate">{{ auth()->user()->name }}</p>
                        </div>
                        <x-heroicon-s-chevron-down class="w-4 h-4 text-gray-400 hidden md:block" />
                    </button>

                    <div x-show="profileDropdownOpen" @click.outside="profileDropdownOpen = false"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-md z-10 border border-gray-100"
                        x-cloak>

                        <div class="p-2">
                            <div class="border-b border-gray-200 px-3 pt-1 pb-2">
                                <p class="text-md font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500 italic">{{ ucfirst(auth()->user()->role) }}</p>
                            </div>
                            <a href="#"
                                class="block px-3 pt-2 pb-1 text-sm text-gray-700 rounded-md hover:text-gray-900">
                                Settings
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left block px-3 py-1 text-sm text-red-600 rounded-md hover:text-red-800 cursor-pointer">
                                    Sign Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
