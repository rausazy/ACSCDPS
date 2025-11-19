    <nav class="relative bg-navbar after:pointer-events-none after:absolute after:inset-x-0 after:bottom-0 after:h-px after:bg-white/10">

        <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
            <div class="relative flex h-16 items-center justify-between">

                <!-- Mobile menu button -->
                <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                    <button id="mobile-menu-button" type="button"
                            class="inline-flex items-center justify-center rounded-md p-2 text-gray-700 hover:bg-white/20 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                        <span class="sr-only">Open main menu</span>
                        <!-- Icon when menu is closed -->
                        <svg id="menu-open-icon" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                        </svg>
                        <!-- Icon when menu is open -->
                        <svg id="menu-close-icon" class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

    <!-- Logo + Links (Desktop) -->
    <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
        <div class="flex shrink-0 items-center bg-white rounded-full p-1 shadow-md">
            <img src="{{ asset('images/CinleiLogo.png') }}" alt="Your Company" class="h-8 w-auto"/>
        </div>
        <div class="hidden sm:ml-6 sm:block">
            <div class="flex space-x-4">
                <a href="{{ url('/') }}"
                class="{{ request()->is('/') ? 'bg-white/20 text-gray-900' : 'text-gray-700 hover:bg-white/20 hover:text-gray-900' }} rounded-md px-3 py-2 text-sm font-medium">
                    Home
                </a>
                <a href="{{ url('/products') }}"
                class="{{ request()->is('products*') ? 'bg-white/20 text-gray-900' : 'text-gray-700 hover:bg-white/20 hover:text-gray-900' }} rounded-md px-3 py-2 text-sm font-medium">
                    Products
                </a>
                <a href="{{ url('/services') }}"
                class="{{ request()->is('services*') ? 'bg-white/20 text-gray-900' : 'text-gray-700 hover:bg-white/20 hover:text-gray-900' }} rounded-md px-3 py-2 text-sm font-medium">
                    Services
                </a>
                <a href="{{ url('/stocks') }}"
                class="{{ request()->is('stocks*') ? 'bg-white/20 text-gray-900' : 'text-gray-700 hover:bg-white/20 hover:text-gray-900' }} rounded-md px-3 py-2 text-sm font-medium">
                    Stocks
                </a>
                <a href="{{ url('/history') }}"
                class="{{ request()->is('history*') ? 'bg-white/20 text-gray-900' : 'text-gray-700 hover:bg-white/20 hover:text-gray-900' }} rounded-md px-3 py-2 text-sm font-medium">
                    History
                </a>
            </div>
        </div>
    </div>

    <!-- Profile dropdown -->
    <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
        <div class="relative ml-3">
            <button type="button"
                    class="flex items-center justify-center rounded-full bg-gray-800 h-8 w-8 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    id="user-menu-button">
                <span class="sr-only">Open user menu</span>
                <!-- Optional: initials or icon can go here -->
            </button>

            <!-- Dropdown menu -->
            <div id="user-menu"
                class="absolute right-0 z-50 mt-2 w-48 origin-top-right rounded-md 
                        bg-purple-600 
                        py-1 shadow-lg ring-1 ring-black ring-opacity-5 hidden transform transition-all duration-200 ease-out scale-95 opacity-0">
                <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-white hover:bg-white/20 rounded">
                    <!-- Profile icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4
                        v2h16v-2c0-2.66-5.33-4-8-4z" clip-rule="evenodd" />
                    </svg>
                    Your Profile
                </a>

                <!-- Logout form -->
                <form action="{{ route('logout') }}" method="POST" class="flex items-center gap-2 px-4 py-2 text-sm text-white hover:bg-white/20 rounded">
                    @csrf
                    <!-- Logout icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M16 13v-2H7V8l-5 4 5 4v-3h9zM20 3H9c-1.1 0-2 
                        .9-2 2v4h2V5h11v14H9v-4H7v4c0 1.1.9 2 2 
                        2h11c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z" clip-rule="evenodd"/>
                    </svg>
                    <button type="submit" class="ml-2">Logout</button>
                </form>
            </div>
        </div>
    </div>


        <!-- Mobile menu (slide-in) -->
        <div id="mobile-menu"
            class="fixed inset-y-0 left-0 z-40 w-64 transform -translate-x-full bg-navbar shadow-xl transition-transform duration-500 ease-[cubic-bezier(0.4,0,0.2,1)] sm:hidden">
            <div class="flex items-center justify-between px-4 py-4 border-b border-gray-200">
                <span class="text-lg font-bold text-gray-900">Menu</span>
                <button id="mobile-close" class="text-gray-700 hover:text-gray-900">
                    ✕
                </button>
            </div>
            <div class="mt-4 space-y-2 px-4">
                <a href="{{ url('/') }}"
                class="{{ request()->is('/') ? 'bg-white/20 text-gray-900' : 'text-gray-900 hover:bg-white/20' }} flex items-center gap-2 rounded-md px-3 py-2 text-base font-medium">
                    Home
                </a>
                <a href="{{ url('/products') }}"
                class="{{ request()->is('products*') ? 'bg-white/20 text-gray-900' : 'text-gray-900 hover:bg-white/20' }} flex items-center gap-2 rounded-md px-3 py-2 text-base font-medium">
                    Products
                </a>
                <a href="{{ url('/services') }}"
                class="{{ request()->is('services*') ? 'bg-white/20 text-gray-900' : 'text-gray-900 hover:bg-white/20' }} flex items-center gap-2 rounded-md px-3 py-2 text-base font-medium">
                    Services
                </a>
                <a href="{{ url('/stocks') }}"
                class="{{ request()->is('stocks*') ? 'bg-white/20 text-gray-900' : 'text-gray-900 hover:bg-white/20' }} flex items-center gap-2 rounded-md px-3 py-2 text-base font-medium">
                    Stocks
                </a>
                <a href="{{ url('/history') }}"
                class="{{ request()->is('history*') ? 'bg-white/20 text-gray-900' : 'text-gray-900 hover:bg-white/20' }} flex items-center gap-2 rounded-md px-3 py-2 text-base font-medium">
                    History
                </a>
            </div>
        </div>

        <!-- Overlay with blur -->
        <div id="overlay"
            class="fixed inset-0 z-30 bg-black/40 backdrop-blur-md hidden opacity-0 transition-opacity duration-500 sm:hidden"></div>
    </nav>

    {{-- Scripts --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const mobileButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            const overlay = document.getElementById('overlay');
            const openIcon = document.getElementById('menu-open-icon');
            const closeIcon = document.getElementById('menu-close-icon');
            const mobileClose = document.getElementById('mobile-close');
            const userButton = document.getElementById('user-menu-button');
            const userMenu = document.getElementById('user-menu');

            function openMenu() {
                mobileMenu.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                setTimeout(() => overlay.classList.add('opacity-100'), 10);
                openIcon.classList.add('hidden');
                closeIcon.classList.remove('hidden');
            }

            function closeMenu() {
                mobileMenu.classList.add('-translate-x-full');
                overlay.classList.remove('opacity-100');
                setTimeout(() => overlay.classList.add('hidden'), 300);
                openIcon.classList.remove('hidden');
                closeIcon.classList.add('hidden');
            }

            mobileButton.addEventListener('click', () => {
                if (mobileMenu.classList.contains('-translate-x-full')) {
                    openMenu();
                } else {
                    closeMenu();
                }
            });

            mobileClose.addEventListener('click', closeMenu);
            overlay.addEventListener('click', closeMenu);

            // auto-close on link click
            const mobileLinks = mobileMenu.querySelectorAll('a');
            mobileLinks.forEach(link => {
                link.addEventListener('click', closeMenu);
            });

            // Profile dropdown toggle
            userButton.addEventListener('click', () => {
                const isOpen = !userMenu.classList.contains('hidden');
                if (isOpen) {
                    userMenu.classList.add('hidden', 'opacity-0', 'scale-95');
                } else {
                    userMenu.classList.remove('hidden');
                    setTimeout(() => {
                        userMenu.classList.remove('opacity-0', 'scale-95');
                    }, 10);
                }
            });

            // Close dropdown if clicked outside
            document.addEventListener('click', (e) => {
                if (!userButton.contains(e.target) && !userMenu.contains(e.target)) {
                    userMenu.classList.add('hidden', 'opacity-0', 'scale-95');
                }
            });
        });
    </script>
