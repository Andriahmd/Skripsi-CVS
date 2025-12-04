@extends('layouts.app')

@section('title', 'Login - MataCare')

@section('content')

<div class="h-screen w-full flex items-center justify-center font-sans bg-gray-50 text-gray-800 overflow-hidden">
    
   
    <div class="max-w-5xl w-full max-h-[95vh] grid md:grid-cols-5 bg-white rounded-2xl shadow-2xl overflow-hidden border border-gray-100 m-4">

       
        <!-- Padding dikembalikan ke p-10 agar lega -->
        <div class="hidden md:flex md:col-span-2 flex-col justify-between p-10 bg-gradient-to-br from-teal-800 via-teal-700 to-teal-900 relative overflow-hidden text-white">
            
            <!-- Pattern Geometris -->
            <div class="absolute inset-0 opacity-20">
                <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <pattern id="grid-pattern" width="40" height="40" patternUnits="userSpaceOnUse">
                            <path d="M0 40L40 0H20L0 20M40 40V20L20 40" stroke="currentColor" stroke-width="1" fill="none"/>
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#grid-pattern)"/>
                </svg>
            </div>

            <!-- Logo Area -->
            <div class="relative z-10">
                <div class="w-12 h-12 bg-white/10 backdrop-blur-md rounded-xl flex items-center justify-center border border-white/20 mb-6 shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </div>
                <h2 class="text-3xl font-bold tracking-tight mb-2 text-white">Selamat Datang</h2>
                <p class="text-teal-100 text-sm leading-relaxed font-light">Masuk ke dashboard pasien untuk melakukan permeriksaan dan melihat hasil medis Anda.</p>
            </div>

            <!-- Footer Kiri -->
            <div class="relative z-10 mt-auto">
                <div class="flex items-center gap-3 mb-4">
                    {{-- <div class="flex -space-x-2">
                        <div class="w-8 h-8 rounded-full bg-teal-600 border-2 border-teal-800 flex items-center justify-center text-xs shadow-sm">A</div>
                        <div class="w-8 h-8 rounded-full bg-teal-500 border-2 border-teal-800 flex items-center justify-center text-xs shadow-sm">B</div>
                        <div class="w-8 h-8 rounded-full bg-teal-400 border-2 border-teal-800 flex items-center justify-center text-xs shadow-sm text-teal-900 font-bold">+2k</div>
                    </div> --}}
                    <div class="text-xs text-teal-100">
                        <span class="font-bold text-white">Akses Aman</span> & Terenkripsi
                    </div>
                </div>
                <p class="text-[10px] text-teal-200/60 uppercase tracking-widest font-semibold">MataCare Patient Portal</p>
            </div>
        </div>

        <!-- KANAN: FORM LOGIN -->
        <!-- 'overflow-y-auto': Jaga-jaga jika layar user sangat kecil, scroll ada di SINI bukan di window browser -->
        <div class="md:col-span-3 p-8 md:p-12 w-full bg-white flex flex-col justify-center overflow-y-auto">
            
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900 mb-1">Masuk ke Akun</h1>
                <p class="text-sm text-gray-500">Silakan masukkan email dan password Anda.</p>
            </div>

            <!-- Spacing dikembalikan ke space-y-6 agar lega -->
            <form method="POST" action="{{ route('login.post') }}" class="space-y-6">
                @csrf

                <!-- Email Input -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide">Alamat Email</label>
                    <div class="relative group">
                        <!-- Padding vertical dikembalikan ke py-3 -->
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="contoh@email.com"
                               required
                               class="w-full pl-4 pr-10 py-3 border border-gray-300 rounded-lg text-gray-900 focus:ring-2 focus:ring-teal-600 focus:border-teal-600 outline-none transition-all placeholder:text-gray-400 text-sm group-hover:border-teal-400 @error('email') border-red-500 @enderror">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none transition-colors group-focus-within:text-teal-600 text-gray-400">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                            </svg>
                        </div>
                    </div>
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Password Input -->
                <div class="space-y-1.5">
                    <div class="flex justify-between items-center">
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide">Password</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-xs text-teal-600 hover:text-teal-800 font-medium transition-colors">
                                Lupa Password?
                            </a>
                        @endif
                    </div>
                    <div class="relative group">
                        <!-- Padding vertical dikembalikan ke py-3 -->
                        <input type="password" name="password" placeholder="••••••••"
                               required
                               class="w-full pl-4 pr-10 py-3 border border-gray-300 rounded-lg text-gray-900 focus:ring-2 focus:ring-teal-600 focus:border-teal-600 outline-none transition-all placeholder:text-gray-400 text-sm group-hover:border-teal-400 @error('password') border-red-500 @enderror">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none transition-colors group-focus-within:text-teal-600 text-gray-400">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-teal-300 text-teal-700 cursor-pointer">
                    <label for="remember_me" class="ml-2 text-sm text-gray-600 cursor-pointer select-none hover:text-gray-800">
                        Ingat saya di perangkat ini
                    </label>
                </div>

                <!-- Tombol Login -->
                <!-- Ukuran tombol dikembalikan ke py-3.5 agar gagah -->
                <button type="submit"
                        class="w-full bg-gradient-to-r from-teal-800 to-teal-700 text-white font-bold py-3.5 rounded-lg hover:from-teal-900 hover:to-teal-800 transition-all shadow-md hover:shadow-lg text-sm flex justify-center items-center gap-2 group transform active:scale-[0.98]">
                    Masuk Sekarang
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                </button>

                <!-- Divider & Register Link -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500 font-medium">Atau</span>
                    </div>
                </div>

                <div class="text-center">
                    <p class="text-sm text-gray-600 mb-2">Belum punya akun?</p>
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center w-full px-4 py-3 border border-teal-700 text-sm font-bold rounded-lg text-teal-800 bg-teal-50 hover:bg-teal-100 transition-colors">
                        Daftar Akun Baru
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection