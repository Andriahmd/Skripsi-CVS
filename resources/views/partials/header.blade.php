<header class="fixed top-0 left-0 right-0 bg-white shadow-md z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">

            <!-- LOGO -->
            <a href="{{ route('home') }}" class="flex items-center">
                <span class="text-2xl font-bold text-teal-600">MataCare</span>
            </a>

            <!-- NAVIGATION -->
            <nav class="hidden md:flex space-x-8 text-gray-700">
                <a href="{{ route('home') }}" class="hover:text-teal-600 transition">Home</a>
                <a href="{{ route('about') }}" class="hover:text-teal-600 transition">About</a>
                <a href="{{ route('pertanyaan') }}" class="hover:text-teal-600 transition">Diagnosis</a>
                <a href="{{ route('pages') }}" class="hover:text-teal-600 transition">Saran</a>
            </nav>

            <!-- ACTION BUTTON -->
            <div class="flex items-center space-x-4">
                @auth
                    <!-- Jika user sudah login -->
                    <span class="text-gray-700 font-medium">Halo, {{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit"
                            class="bg-red-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-red-700 transition">
                            Logout
                        </button>
                    </form>
                @else
                    <!-- Jika user belum login -->
                    <a href="{{ route('login') }}"
                        class="bg-teal-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-teal-700 transition">
                        Login
                    </a>
                @endauth
            </div>

        </div>
    </div>
</header>