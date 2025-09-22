<header class="sticky top-0 z-20 border-b border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <div class="flex items-center gap-3">
                <button @click.stop="sidebarOpen = !sidebarOpen"
                    class="text-gray-500 focus:outline-none lg:hidden dark:text-gray-400">
                    <x-heroicon-o-bars-3 class="h-6 w-6" />
                </button>
            </div>

            <div class="flex items-center gap-2">
                <button id="darkModeToggle"
                    class="flex h-10 w-10 items-center justify-center rounded-full text-gray-500 transition-colors hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600/50">
                    <span class="sun-icon"><x-heroicon-o-sun class="h-6 w-6" /></span>
                    <span class="moon-icon hidden"><x-heroicon-o-moon class="h-6 w-6" /></span>
                </button>

                <button
                    class="relative flex h-10 w-10 items-center justify-center rounded-full text-gray-500 transition-colors hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600/50">
                    <x-heroicon-o-bell class="h-6 w-6" />
                    <span class="absolute -right-0 -top-0 h-2 w-2 rounded-full bg-red-500"></span>
                </button>

                <div class="hidden h-7 w-px bg-gray-200 sm:block dark:bg-gray-700"></div>

                <div class="relative">
                    <button @click="profileDropdownOpen = !profileDropdownOpen" class="flex items-center gap-3">
                        <img class="h-9 w-9 rounded-full object-cover"
                            src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=dcfce7&color=16a3a"
                            alt="User avatar">
                        <div class="hidden text-left md:block">
                            <p class="truncate text-sm font-medium text-gray-800 dark:text-gray-200">
                                {{ auth()->user()->name }}</p>
                        </div>
                        <x-heroicon-s-chevron-down class="hidden h-4 w-4 text-gray-400 md:block dark:text-gray-400" />
                    </button>

                    <div x-show="profileDropdownOpen" @click.outside="profileDropdownOpen = false" x-transition
                        class="absolute right-0 z-10 mt-2 w-48 rounded-lg border border-gray-100 bg-white shadow-md dark:border-gray-700 dark:bg-gray-800"
                        x-cloak>
                        <div class="p-2">
                            <div class="border-b border-gray-200 px-3 pb-2 pt-1 dark:border-gray-700">
                                <p class="text-md font-semibold text-gray-800 dark:text-gray-200">
                                    {{ auth()->user()->name }}</p>
                                <p class="text-xs italic text-gray-500 dark:text-gray-400">
                                    {{ ucfirst(auth()->user()->role) }}</p>
                            </div>
                            @if (auth()->user()->role === 'superadmin')
                                <a href="{{ route('settings.index') }}"
                                    class="block w-full rounded-md px-3 pb-1 pt-2 text-left text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700/50">
                                    Pengaturan
                                </a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="block w-full cursor-pointer rounded-md px-3 py-1 text-left text-sm text-red-600 hover:bg-gray-100 dark:text-red-500 dark:hover:bg-gray-700/50">
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
