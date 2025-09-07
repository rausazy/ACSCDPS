<nav class="bg-navbar shadow-md">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <img src="{{ asset('images/CinleiLogo.png') }}" alt="Logo" class="h-8 w-auto">
            </div>

            <!-- Desktop Links -->
            <div class="hidden sm:flex sm:space-x-6">
                <a href="/" class="text-gray-700 hover:text-indigo-600 font-medium">Home</a>
                <a href="/product" class="text-gray-700 hover:text-indigo-600 font-medium">Product</a>
                <a href="/services" class="text-gray-700 hover:text-indigo-600 font-medium">Services</a>
            </div>

            <!-- Profile + Mobile Menu Button -->
            <div class="flex items-center space-x-3">
                <!-- Profile -->
                <div class="relative">
                    <button id="user-menu-button" class="flex rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <img class="h-8 w-8 rounded-full bg-gray-800"
                             src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                             alt="">
                    </button>
                    <!-- Dropdown -->
                    <div id="user-menu" class="absolute right-0 mt-2 w-48 rounded-md bg-white shadow-lg hidden opacity-0 scale-95 transform transition-all duration-200 origin-top-right z-50">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Your Profile</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sign out</a>
                    </div>
                </div>

                <!-- Mobile menu button -->
                <div class="sm:hidden">
                    <button id="mobile-menu-button" class="p-2 text-gray-700 hover:text-indigo-600 focus:outline-none">
                        <!-- Hamburger -->
                        <svg id="menu-open-icon" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <!-- Close -->
                        <svg id="menu-close-icon" class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="sm:hidden hidden bg-white border-t border-gray-200 px-4 py-3 space-y-2 transition-all duration-300">
        <a href="/" class="block text-gray-700 hover:text-indigo-600">Home</a>
        <a href="/product" class="block text-gray-700 hover:text-indigo-600">Product</a>
        <a href="/services" class="block text-gray-700 hover:text-indigo-600">Services</a>
    </div>
</nav>

{{-- Scripts --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Profile dropdown
        const profileBtn = document.getElementById('user-menu-button');
        const profileMenu = document.getElementById('user-menu');

        profileBtn.addEventListener('click', () => {
            if (profileMenu.classList.contains('hidden')) {
                profileMenu.classList.remove('hidden');
                setTimeout(() => profileMenu.classList.remove('opacity-0', 'scale-95'), 10);
                profileMenu.classList.add('opacity-100', 'scale-100');
            } else {
                profileMenu.classList.remove('opacity-100', 'scale-100');
                profileMenu.classList.add('opacity-0', 'scale-95');
                setTimeout(() => profileMenu.classList.add('hidden'), 150);
            }
        });

        // Mobile menu
        const mobileBtn = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        const openIcon = document.getElementById('menu-open-icon');
        const closeIcon = document.getElementById('menu-close-icon');

        mobileBtn.addEventListener('click', () => {
            if (mobileMenu.classList.contains('hidden')) {
                mobileMenu.classList.remove('hidden');
                openIcon.classList.add('hidden');
                closeIcon.classList.remove('hidden');
            } else {
                mobileMenu.classList.add('hidden');
                openIcon.classList.remove('hidden');
                closeIcon.classList.add('hidden');
            }
        });
    });
</script>
