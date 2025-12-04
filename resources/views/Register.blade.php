@extends('layouts.app')

@section('title', 'Register - MataCare')

@section('content')
    <!-- Container Utama: Background lebih netral dan bersih -->
    <div class="min-h-screen flex items-center justify-center p-4 font-sans bg-gray-50 text-gray-800">

        <!-- Card Wrapper: Shadow lebih soft, sudut lebih tajam (rounded-2xl) untuk kesan modern -->
        <div
            class="max-w-5xl w-full grid md:grid-cols-5 bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">

            <!-- KIRI: BRANDING & PROFESSIONAL LOOK (Lebar 2/5) -->
            <div
                class="hidden md:flex md:col-span-2 flex-col justify-between p-10 bg-teal-900 relative overflow-hidden text-white">

                <!-- Dekorasi Background: Pola Geometris Halus (Bukan Blob) -->
                <div class="absolute inset-0 opacity-10">
                    <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <pattern id="grid-pattern" width="40" height="40" patternUnits="userSpaceOnUse">
                                <path d="M0 40L40 0H20L0 20M40 40V20L20 40" stroke="currentColor" stroke-width="1"
                                    fill="none" />
                            </pattern>
                        </defs>
                        <rect width="100%" height="100%" fill="url(#grid-pattern)" />
                    </svg>
                </div>

                <!-- Logo / Simbol Abstrak -->
                <div class="relative z-10">
                    <div
                        class="w-12 h-12 bg-teal-700/50 backdrop-blur-sm rounded-lg flex items-center justify-center border border-teal-600 mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-300" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold tracking-tight mb-2">MataCare</h2>
                    <p class="text-teal-200/80 text-sm leading-relaxed">Platform kesehatan mata untuk pengecekan gejala
                        computer vision syndrome.</p>
                </div>

                <!-- Footer Kiri -->
                <div class="relative z-10 mt-auto">
                    <div class="flex items-center gap-3 mb-4">
                    </div>
                    <p class="text-[10px] text-teal-500 uppercase tracking-widest font-semibold">Trusted Healthcare System
                    </p>
                </div>
            </div>

            <!-- KANAN: FORM REGISTER (Lebar 3/5) -->
            <div class="md:col-span-3 p-8 md:p-12 w-full bg-white flex flex-col justify-center">

                <div class="mb-8">
                    <h1 class="text-2xl font-bold text-gray-900 mb-1">Pendaftaran Akun</h1>
                    <p class="text-sm text-gray-500">Lengkapi data diri Anda untuk akses layanan medis.</p>
                </div>

                <form method="POST" action="{{ route('register.post') }}" class="space-y-5">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <!-- Nama -->
                        <div class="md:col-span-2 space-y-1.5">
                            <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide">Nama
                                Lengkap</label>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="Sesuai KTP" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 focus:ring-2 focus:ring-teal-900/20 focus:border-teal-900 outline-none transition-all placeholder:text-gray-400 text-sm @error('name') border-red-500 @enderror">
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Umur -->
                        <div class="space-y-1.5">
                            <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide">Usia</label>
                            <input type="number" name="umur" value="{{ old('umur') }}" placeholder="Thn" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 focus:ring-2 focus:ring-teal-900/20 focus:border-teal-900 outline-none transition-all placeholder:text-gray-400 text-sm @error('umur') border-red-500 @enderror">
                            @error('umur') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide">Alamat
                            Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="contoh@email.com" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 focus:ring-2 focus:ring-teal-900/20 focus:border-teal-900 outline-none transition-all placeholder:text-gray-400 text-sm @error('email') border-red-500 @enderror">
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Password Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-1.5">
                            <label
                                class="block text-xs font-semibold text-gray-600 uppercase tracking-wide">Password</label>
                            <input type="password" name="password" placeholder="••••••••" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 focus:ring-2 focus:ring-teal-900/20 focus:border-teal-900 outline-none transition-all placeholder:text-gray-400 text-sm @error('password') border-red-500 @enderror">
                            @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label
                                class="block text-xs font-semibold text-gray-600 uppercase tracking-wide">Konfirmasi</label>
                            <input type="password" name="password_confirmation" placeholder="••••••••" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 focus:ring-2 focus:ring-teal-900/20 focus:border-teal-900 outline-none transition-all placeholder:text-gray-400 text-sm">
                        </div>
                    </div>

                    <!-- Terms -->
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="terms" type="checkbox"
                                class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-teal-300"
                                required>
                        </div>
                        <label for="terms" class="ml-2 text-xs font-medium text-gray-500">
                            Saya menyetujui <a href="#" class="text-teal-700 hover:underline">Syarat & Ketentuan</a> serta
                            <a href="#" class="text-teal-700 hover:underline">Kebijakan Privasi</a> MataCare.
                        </label>
                    </div>

                    <!-- Tombol Submit -->
                    <button type="submit"
                        class="w-full bg-teal-900 text-white font-semibold py-3.5 rounded-lg hover:bg-teal-800 transition-colors shadow-sm text-sm flex justify-center items-center gap-2 group">
                        Buat Akun
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>

                    <!-- Link Login -->
                    <div class="text-center pt-2">
                        <p class="text-sm text-gray-500">
                            Sudah terdaftar?
                            <a href="{{ route('login') }}"
                                class="font-semibold text-teal-900 hover:text-teal-700 transition">
                                Masuk
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection