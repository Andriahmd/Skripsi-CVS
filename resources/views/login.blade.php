@extends('layouts.app')

@section('title', 'Login - MataCare')

@section('content')
<div class="bg-gradient-to-br from-teal-50 to-emerald-50 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-6xl w-full grid md:grid-cols-2 gap-8 bg-white rounded-3xl shadow-xl overflow-hidden">

        <!-- LEFT ILLUSTRATION -->
        <div class="hidden md:flex flex-col justify-center items-center p-12 bg-gradient-to-br from-teal-50 to-emerald-100">
            <!-- (Ilustrasi tetap sama seperti punyamu di atas) -->
        </div>

        <!-- RIGHT: LOGIN FORM -->
        <div class="flex flex-col justify-center p-8 md:p-12 lg:p-16">
            <h1 class="text-3xl font-bold text-teal-700 mb-8">Welcome</h1>

            <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
                @csrf

                <!-- EMAIL -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" placeholder="Masukkan email"
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent outline-none transition">
                </div>

                <!-- PASSWORD -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input type="password" name="password" placeholder="Masukkan password"
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent outline-none transition">
                </div>

                <!-- REGISTER LINK -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Belum memiliki akun?
                        <a href="{{ route('register') }}"
                           class="font-medium text-teal-600 hover:text-teal-700 underline underline-offset-2 transition">
                            Register
                        </a>
                    </p>
                </div>

                <!-- SUBMIT BUTTON -->
                <button type="submit"
                        class="w-full bg-teal-600 text-white font-semibold py-3 rounded-xl hover:bg-teal-700 transition shadow-md">
                    Login
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
