<header class="fixed top-0 left-0 right-0 bg-white shadow-md z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">

            <!-- LOGO -->
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <!-- Opsional: Tambahkan Logo Icon jika ada -->
                    <span class="text-2xl font-bold text-teal-600 tracking-tight">MataCare</span>
                </a>
            </div>

            <!-- DESKTOP MENU (Hidden on Mobile) -->
            <nav class="hidden md:flex space-x-8 text-gray-700">
                <a href="{{ route('home') }}" class="hover:text-teal-600 font-medium transition duration-150 ease-in-out {{ request()->routeIs('home') ? 'text-teal-600' : '' }}">Home</a>
                <a href="{{ route('about') }}" class="hover:text-teal-600 font-medium transition duration-150 ease-in-out {{ request()->routeIs('about') ? 'text-teal-600' : '' }}">About</a>
                <a href="{{ route('pertanyaan') }}" class="hover:text-teal-600 font-medium transition duration-150 ease-in-out {{ request()->routeIs('pertanyaan') ? 'text-teal-600' : '' }}">Diagnosis</a>
                <a href="{{ route('pages') }}" class="hover:text-teal-600 font-medium transition duration-150 ease-in-out {{ request()->routeIs('pages') ? 'text-teal-600' : '' }}">Saran</a>
            </nav>

            <!-- DESKTOP ACTION BUTTONS -->
            <div class="hidden md:flex items-center space-x-4">
                @auth
                    <div class="flex items-center gap-4">
                        <span class="text-gray-700 font-medium text-sm">Hi, {{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="bg-red-50 text-red-600 border border-red-200 px-4 py-2 rounded-lg font-medium hover:bg-red-600 hover:text-white transition duration-200 text-sm">
                                Logout
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="bg-teal-600 text-white px-5 py-2.5 rounded-lg font-bold hover:bg-teal-700 transition shadow-sm hover:shadow-md">
                        Login
                    </a>
                @endauth
            </div>

            <!-- MOBILE MENU BUTTON (Hamburger) -->
            <div class="-mr-2 flex md:hidden">
                <button type="button" id="mobile-menu-btn" class="bg-white inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-teal-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-teal-500" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <!-- Icon Menu (Hamburger) -->
                    <svg class="block h-7 w-7" id="icon-menu" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <!-- Icon Close (X) - Hidden by default -->
                    <svg class="hidden h-7 w-7" id="icon-close" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- MOBILE MENU (Hidden by default) -->
    <div class="hidden md:hidden bg-white border-t border-gray-100 shadow-lg absolute w-full left-0" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-teal-600 hover:bg-teal-50 transition {{ request()->routeIs('home') ? 'bg-teal-50 text-teal-600' : '' }}">Home</a>
            <a href="{{ route('about') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-teal-600 hover:bg-teal-50 transition {{ request()->routeIs('about') ? 'bg-teal-50 text-teal-600' : '' }}">About</a>
            <a href="{{ route('pertanyaan') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-teal-600 hover:bg-teal-50 transition {{ request()->routeIs('pertanyaan') ? 'bg-teal-50 text-teal-600' : '' }}">Diagnosis</a>
            <a href="{{ route('pages') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-teal-600 hover:bg-teal-50 transition {{ request()->routeIs('pages') ? 'bg-teal-50 text-teal-600' : '' }}">Saran</a>
        </div>

        <!-- Mobile Action Buttons -->
        <div class="pt-4 pb-4 border-t border-gray-200">
            @auth
                <div class="flex items-center px-5 mb-3">
                    <div class="flex-shrink-0">
                        <!-- User Avatar Placeholder -->
                        <div class="h-10 w-10 rounded-full bg-teal-100 flex items-center justify-center text-teal-600 font-bold">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium leading-none text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="text-sm font-medium leading-none text-gray-500 mt-1">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                <div class="px-2 space-y-1">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-red-600 hover:bg-red-50 hover:text-red-800 transition">
                            Logout
                        </button>
                    </form>
                </div>
            @else
                <div class="px-5">
                    <a href="{{ route('login') }}" class="block w-full text-center px-4 py-3 rounded-lg font-bold text-white bg-teal-600 hover:bg-teal-700 shadow-sm transition">
                        Login Sekarang
                    </a>
                </div>
            @endauth
        </div>
    </div>
</header>

<!-- SCRIPT untuk Toggle Menu Mobile -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');
        const iconMenu = document.getElementById('icon-menu');
        const iconClose = document.getElementById('icon-close');

        btn.addEventListener('click', () => {
            // Toggle visibility menu
            menu.classList.toggle('hidden');
            
            // Toggle icon (Hamburger <-> Silang)
            iconMenu.classList.toggle('hidden');
            iconClose.classList.toggle('hidden');
        });

        // Opsional: Tutup menu jika klik di luar
        document.addEventListener('click', (e) => {
            if (!btn.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.add('hidden');
                iconMenu.classList.remove('hidden');
                iconClose.classList.add('hidden');
            }
        });
    });
</script>