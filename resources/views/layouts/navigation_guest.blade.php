<nav x-data="{ open: false, scrolled: false }" 
     @scroll.window="scrolled = (window.pageYOffset > 10)"
     :class="{'bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm': scrolled, 'bg-white dark:bg-gray-800': !scrolled}"
     class="fixed w-full z-50 border-b border-gray-100 dark:border-gray-700 transition-all duration-300">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ url('/') }}">
                        <span class="text-2xl font-bold block h-9 w-auto fill-current text-red-500 dark:text-red-400">Deskalink</span>
                    </a>
                </div>
            </div>

            <!-- Guest Links -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-4">
                <x-nav-link :href="route('login')" class="text-sm font-medium text-red-500 dark:text-gray-300 hover:text-red-700 dark:hover:white transition-colors duration-300">
                    {{ __('Login') }}
                </x-nav-link>
                <x-nav-link :href="route('register')" class="text-sm font-medium text-red-500 dark:text-gray-300 hover:text-red-700 dark:hover:white transition-colors duration-300">
                    {{ __('Register') }}
                </x-nav-link>
            </div>

            <!-- Hamburger Menu -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('login')">
                {{ __('Login') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('register')">
                {{ __('Register') }}
            </x-responsive-nav-link>
        </div>
    </div>
</nav>