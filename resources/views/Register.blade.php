@extends('layouts.app')

@section('title', 'Register - MataCare')

@section('content')

    @if ($errors->any())
        <div id="errorModal" class="fixed inset-0 z-50 flex items-center justify-center px-4 pointer-events-none">
            <div
                class="bg-white rounded-2xl shadow-2xl max-w-sm w-full transform transition-all pointer-events-auto p-6 text-center animate-fade-in-up border border-gray-100">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-6">
                    <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Pendaftaran Gagal</h3>
                <div class="text-sm text-gray-500 mb-6 leading-relaxed">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
                <button onclick="closeModal('errorModal')"
                    class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-3 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:text-sm transition-colors">
                    Tutup
                </button>
            </div>
        </div>
    @endif

    @if (session('success'))
        <div id="successModal" class="fixed inset-0 z-50 flex items-center justify-center px-4 pointer-events-none">
            <div
                class="bg-white rounded-2xl shadow-2xl max-w-sm w-full transform transition-all pointer-events-auto p-6 text-center animate-fade-in-up border border-gray-100">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-6">
                    <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>

                <h3 class="text-xl font-bold text-gray-900 mb-2">Berhasil!</h3>

                <p class="text-sm text-gray-500 mb-6 leading-relaxed">
                    {{ session('success') }}
                </p>
                <button onclick="closeModal('successModal')"
                    class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-3 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:text-sm transition-colors">
                    Lanjutkan
                </button>
            </div>
        </div>
    @endif

    {{-- 2. KONTEN UTAMA (FORM) --}}
    <div class="min-h-screen flex items-center justify-center p-4 font-sans text-gray-800">
        <div
            class="max-w-5xl w-full grid md:grid-cols-5 bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">

            {{-- Bagian Kiri (Teal Background) --}}
            <div
                class="hidden md:flex md:col-span-2 flex-col justify-between p-10 bg-teal-900 relative overflow-hidden text-white">
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

                <div class="relative z-10 mt-auto">
                    <p class="text-[10px] text-teal-500 uppercase tracking-widest font-semibold">Trusted Healthcare System
                    </p>
                </div>
            </div>

            <div class="md:col-span-3 p-8 md:p-12 w-full bg-white flex flex-col justify-center">

                <div class="mb-8">
                    <h1 class="text-2xl font-bold text-gray-900 mb-1">Pendaftaran Akun</h1>
                    <p class="text-sm text-gray-500">Lengkapi data diri Anda untuk akses layanan medis.</p>
                </div>

                <form method="POST" action="{{ route('register.post') }}" class="space-y-5">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <div class="md:col-span-2 space-y-1.5">
                            <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide">Nama
                                Lengkap</label>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="Sesuai KTP" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 focus:ring-2 focus:ring-teal-900/20 focus:border-teal-900 outline-none transition-all placeholder:text-gray-400 text-sm @error('name') border-red-500 @enderror">
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide">Usia</label>
                            <input type="number" name="umur" value="{{ old('umur') }}" placeholder="Thn" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 focus:ring-2 focus:ring-teal-900/20 focus:border-teal-900 outline-none transition-all placeholder:text-gray-400 text-sm @error('umur') border-red-500 @enderror">
                            @error('umur') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide">Alamat
                            Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="contoh@email.com" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 focus:ring-2 focus:ring-teal-900/20 focus:border-teal-900 outline-none transition-all placeholder:text-gray-400 text-sm @error('email') border-red-500 @enderror">
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

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

                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="terms" type="checkbox" required
                                class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-teal-300">
                        </div>
                        <label for="terms" class="ml-2 text-xs font-medium text-gray-500">
                            Saya menyetujui <a href="#" class="text-teal-700 hover:underline">Syarat & Ketentuan</a> serta
                            <a href="#" class="text-teal-700 hover:underline">Kebijakan Privasi</a> MataCare.
                        </label>
                    </div>

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


    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translate3d(0, 20px, 0);
            }

            to {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.4s ease-out forwards;
        }
    </style>
    <script>
        function closeModal(modalId) {
            const modalWrapper = document.getElementById(modalId);
            if (modalWrapper) {
                const modalContent = modalWrapper.querySelector('div');
                modalContent.style.opacity = '0';
                modalContent.style.transform = 'scale(0.95)';
                modalContent.style.transition = 'all 0.2s ease-in';
                setTimeout(() => { modalWrapper.remove(); }, 200);
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const successModal = document.getElementById('successModal');
            if (successModal) setTimeout(() => { closeModal('successModal'); }, 5000);

            const errorModal = document.getElementById('errorModal');
            if (errorModal) setTimeout(() => { closeModal('errorModal'); }, 5000);
        });
    </script>

@endsection