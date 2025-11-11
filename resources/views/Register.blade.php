@extends('layouts.app')

@section('title', 'Register - MataCare')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-emerald-50 to-teal-50 p-4">
    <div class="bg-white rounded-3xl shadow-xl p-8 max-w-md w-full space-y-6">
        <h2 class="text-3xl font-bold text-center text-teal-700">Daftar Akun</h2>

        <form method="POST" action="{{ route('register.post') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-gray-700 font-medium mb-2">Nama</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-teal-500 outline-none">
                @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-teal-500 outline-none">
                @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">Umur</label>
                <input type="number" name="umur" value="{{ old('umur') }}"
                       class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-teal-500 outline-none">
                @error('umur') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">Password</label>
                <input type="password" name="password"
                       class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-teal-500 outline-none">
                @error('password') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">Konfirmasi Password</label>
                <input type="password" name="password_confirmation"
                       class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-teal-500 outline-none">
            </div>

            <button type="submit" class="w-full bg-teal-600 text-white py-3 rounded-xl hover:bg-teal-700 transition">
                Daftar
            </button>

            <p class="text-center text-sm text-gray-600">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-teal-600 hover:text-teal-700 font-semibold">Login</a>
            </p>
        </form>
    </div>
</div>
@endsection
