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
                <div class="flex shrink-0 items-center">
                    <img src="{{ asset('images/CinleiLogo.png') }}" alt="Your Company" class="h-8 w-auto"/>
                </div>
                <div class="hidden sm:ml-6 sm:block">
                    <div class="flex space-x-4">
                        <a href="{{ url('/') }}" class="rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-white/20 hover:text-gray-900">Home</a>
                        <a href="{{ url('/products') }}" class="rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-white/20 hover:text-gray-900">Products</a>
                        <a href="{{ url('/services') }}" class="rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-white/20 hover:text-gray-900">Services</a>
                    </div>
                </div>
            </div>

            <!-- Profile dropdown -->
            <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                <div class="relative ml-3">
                    <button type="button"
                            class="flex rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            id="user-menu-button">
                        <span class="sr-only">Open user menu</span>
                        <img class="h-8 w-8 rounded-full bg-gray-800"
                             src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                             alt="">
                    </button>

                    <!-- Dropdown menu -->
                    <div id="user-menu"
                         class="absolute right-0 z-50 mt-2 w-48 origin-top-right rounded-md bg-gray-800 py-1 shadow-lg ring-1 ring-black ring-opacity-5 hidden transform transition-all duration-200 ease-out scale-95 opacity-0">
                        <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white">
                            <!-- Profile icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-black" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 2a5 5 0 00-5 5v1a5 5 0 1010 0V7a5 5 0 00-5-5zm-7 14a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                            Your Profile
                        </a>
                        <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white">
                            <!-- Settings icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-black" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M11.3 1.046a1 1 0 00-2.6 0L8.293 2.5a1 1 0 01-.832.445H5.25a1 1 0 100 2h2.211a1 1 0 01.832.445l.407.954a1 1 0 001.794 0l.407-.954a1 1 0 01.832-.445H14.75a1 1 0 100-2h-2.211a1 1 0 01-.832-.445L11.3 1.046zM10 6a4 4 0 00-4 4v4a4 4 0 108 0v-4a4 4 0 00-4-4z" clip-rule="evenodd" />
                            </svg>
                            Settings
                        </a>

                      <a href="#"
                        class="w-full flex items-center gap-2 px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white">
                            <!-- Logout icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-black" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h6a1 1 0 010 2H5v10h5a1 1 0 110 2H4a1 1 0 01-1-1V4zm10.707 5.293a1 1 0 010 1.414L11.414 13H9a1 1 0 110-2h2.414l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Sign out
                        </a>
                        </form>
                    </div>
                </div>
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
            <a href="{{ url('/') }}" class="flex items-center gap-2 rounded-md px-3 py-2 text-base font-medium text-gray-900 hover:bg-white/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-black" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10.707 1.293a1 1 0 00-1.414 0l-8 8a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h10a1 1 0 001-1v-6.586l1.293 1.293a1 1 0 001.414-1.414l-8-8z"/>
                </svg>
                Home
            </a>
            <a href="{{ url('/products') }}" class="flex items-center gap-2 rounded-md px-3 py-2 text-base font-medium text-gray-900 hover:bg-white/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-black" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M4 3a2 2 0 00-2 2v2a2 2 0 002 2v6a2 2 0 002 2h8a2 2 0 002-2V9a2 2 0 002-2V5a2 2 0 00-2-2H4z"/>
                </svg>
                Products
            </a>
            <a href="{{ url('/services') }}" class="flex items-center gap-2 rounded-md px-3 py-2 text-base font-medium text-gray-900 hover:bg-white/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-black" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11V5a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0V9h2a1 1 0 100-2h-2z" clip-rule="evenodd" />
                </svg>
                Services
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
