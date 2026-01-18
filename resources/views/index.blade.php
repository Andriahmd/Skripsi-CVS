@extends('layouts.app')

@section('content')

    <main class="overflow-x-hidden">
        {{-- Spacer Navbar --}}
        <div class="h-20 lg:h-20"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">

            {{-- Dekorasi Background (Blobs) --}}
            <div
                class="absolute top-0 right-0 -mr-20 -mt-20 w-72 h-72 bg-teal-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob">
            </div>
            <div
                class="absolute top-0 left-0 -ml-20 -mt-20 w-72 h-72 bg-blue-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000">
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center relative z-10">

                {{-- Kolom Teks --}}
                <div class="text-center lg:text-left order-2 lg:order-1">
                    {{-- Label MataCare --}}
                    <div
                        class="inline-flex items-center px-4 py-2 rounded-full bg-teal-50 text-teal-700 text-xs font-bold tracking-wide uppercase mb-6 border border-teal-100 shadow-sm">
                        <i class="fas fa-check-circle mr-2 text-teal-500"></i> Sistem Pakar MataCare
                    </div>

                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-gray-900 mb-6 leading-tight">
                        Tes Cepat Deteksi <br> Gejala CVS
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-600 to-teal-400">
                            Berbasis Website
                        </span>
                    </h1>

                    <p class="text-gray-600 mb-8 text-lg sm:text-xl leading-relaxed max-w-lg mx-auto lg:mx-0">
                        Lindungi penglihatan Anda. Deteksi dini gejala <em>Computer Vision Syndrome</em> (CVS) secara akurat
                        akibat penggunaan gadget harian.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="{{ route('pertanyaan') }}"
                            class="px-8 py-4 rounded-full bg-teal-600 text-white font-bold text-lg shadow-lg shadow-teal-500/30 hover:bg-teal-700 hover:shadow-teal-500/50 hover:-translate-y-1 transition-all duration-300 transform">
                            <i class="fas fa-stethoscope mr-2"></i> Mulai Diagnosa
                        </a>
                        <a href="{{ route('about') }}"
                            class="px-8 py-4 rounded-full bg-white text-teal-700 border border-teal-200 font-bold text-lg shadow-sm hover:bg-teal-50 hover:border-teal-300 transition-all duration-300">
                            Pelajari Lebih Lanjut
                        </a>
                    </div>
                </div>

                {{-- Kolom Gambar --}}
                <div class="relative order-1 lg:order-2">
                    <div
                        class="relative rounded-3xl overflow-hidden shadow-2xl border-4 border-white transform hover:scale-[1.01] transition duration-500 group">
                        <img src="https://i.pinimg.com/736x/1a/d1/96/1ad19650f28ef335609605a56f6dd08d.jpg"
                            alt="Ilustrasi Pemeriksaan Mata CVS"
                            class="w-full h-auto object-cover transform group-hover:scale-105 transition duration-700" />
                        {{-- Overlay Gradient --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-teal-900/40 to-transparent"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Spacer --}}
        <div class="py-16"></div>
        <div id="panduan" class="py-20 bg-white relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">Pahami Kesehatan Mata Anda</h2>
                    <div class="w-24 h-1.5 bg-teal-500 mx-auto rounded-full mb-6"></div>
                    <p class="text-gray-500 max-w-2xl mx-auto text-lg">
                        Mengenali gejala dan menerapkan kebiasaan baik adalah kunci mencegah kerusakan mata permanen.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                    {{-- Card 1: Gejala Umum --}}
                    <div
                        class="group bg-white rounded-3xl p-8 border border-gray-100 shadow-xl shadow-gray-200/50 hover:shadow-2xl hover:shadow-teal-500/10 hover:-translate-y-2 transition-all duration-300 relative overflow-hidden">
                        <div
                            class="absolute top-0 right-0 w-32 h-32 bg-teal-50 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110">
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3 text-center">Gejala Umum</h3>
                        <p class="text-gray-500 text-sm leading-relaxed text-center">
                            Mata kering, penglihatan kabur, sakit kepala, hingga nyeri leher adalah tanda tubuh Anda mulai
                            mengalami kelelahan visual.
                        </p>
                    </div>

                    {{-- Card 2: Aturan 20-20-20 --}}
                    <div
                        class="group bg-white rounded-3xl p-8 border border-gray-100 shadow-xl shadow-gray-200/50 hover:shadow-2xl hover:shadow-teal-500/10 hover:-translate-y-2 transition-all duration-300 relative overflow-hidden">
                        <div
                            class="absolute top-0 right-0 w-32 h-32 bg-blue-50 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110">
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3 text-center">Aturan 20-20-20</h3>
                        <p class="text-gray-500 text-sm leading-relaxed text-center">
                            Setiap <strong>20 menit</strong> menatap layar, alihkan pandangan sejauh <strong>20
                                kaki</strong> selama minimal <strong>20 detik</strong>.
                        </p>
                    </div>
                    {{-- Card 3: Ergonomi --}}
                    <div
                        class="group bg-white rounded-3xl p-8 border border-gray-100 shadow-xl shadow-gray-200/50 hover:shadow-2xl hover:shadow-teal-500/10 hover:-translate-y-2 transition-all duration-300 relative overflow-hidden">
                        <div
                            class="absolute top-0 right-0 w-32 h-32 bg-emerald-50 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110">
                        </div>

                        <h3 class="text-xl font-bold text-gray-900 mb-3 text-center">Ergonomi Kerja</h3>
                        <p class="text-gray-500 text-sm leading-relaxed text-center">
                            Atur jarak layar 50-60 cm dari mata. Pastikan pencahayaan ruangan seimbang dan tidak memantulkan
                            silau.
                        </p>
                    </div>

                </div>
            </div>
        </div>

        <div class="py-24 bg-white relative overflow-hidden">
            {{-- Dekorasi Background (SAMA PERSIS DENGAN HEADER) --}}
            <div
                class="absolute top-0 left-0 -ml-20 -mt-20 w-96 h-96 bg-teal-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob">
            </div>
            <div
                class="absolute bottom-0 right-0 -mr-20 -mb-20 w-96 h-96 bg-blue-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000">
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                {{-- Judul Section --}}
                <div class="text-center mb-16 max-w-3xl mx-auto">
                    <span
                        class="bg-red-50 text-red-600 px-4 py-1 rounded-full text-xs font-bold tracking-wide uppercase border border-red-100">Penting
                        Diketahui</span>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mt-4 mb-6">
                        Bahaya Tersembunyi di Balik Layar
                    </h2>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        Paparan jangka panjang tanpa perlindungan dapat memicu gangguan kesehatan serius.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                    {{-- Bahaya 1: Sinar Biru --}}
                    <div
                        class="bg-white/90 backdrop-blur-sm rounded-3xl p-6 border border-gray-100 shadow-xl hover:shadow-2xl hover:border-teal-300 transition-all duration-300 group">
                        {{-- Wrapper Gambar --}}
                        <div class="relative h-48 mb-6 overflow-hidden rounded-2xl shadow-sm">
                            <img src="https://i.pinimg.com/736x/c7/55/4b/c7554bf69a0284f36bffb1b70dcbf26b.jpg"
                                alt="Bahaya Sinar Biru"
                                class="object-cover w-full h-full transform group-hover:scale-110 transition duration-700">
                            {{-- Overlay Gradient Tipis --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                        </div>

                        <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-teal-600 transition-colors">Sinar
                            Biru (HEV)</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Layar digital memancarkan <em>High-Energy Visible light</em>. Gelombang pendek ini menembus
                            hingga retina, berisiko mempercepat degenerasi makula.
                        </p>
                    </div>

                    {{-- Bahaya 2: Mata Kering --}}
                    <div
                        class="bg-white/90 backdrop-blur-sm rounded-3xl p-6 border border-gray-100 shadow-xl hover:shadow-2xl hover:border-teal-300 transition-all duration-300 group">
                        {{-- Wrapper Gambar --}}
                        <div class="relative h-48 mb-6 overflow-hidden rounded-2xl shadow-sm">
                            <img src="https://i.pinimg.com/736x/8e/1e/4c/8e1e4c11b79da3e5c138673ac24dcb75.jpg"
                                alt="Mata Lelah dan Kering"
                                class="object-cover w-full h-full transform group-hover:scale-110 transition duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                        </div>

                        <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-teal-600 transition-colors">Mata
                            Kering & Iritasi</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Frekuensi berkedip turun drastis dari 20x menjadi 5x per menit saat menatap layar. Ini membuat
                            air mata menguap cepat dan mata iritasi.
                        </p>
                    </div>

                    {{-- Bahaya 3: Gangguan Tidur --}}
                    <div
                        class="bg-white/90 backdrop-blur-sm rounded-3xl p-6 border border-gray-100 shadow-xl hover:shadow-2xl hover:border-teal-300 transition-all duration-300 group">
                        {{-- Wrapper Gambar --}}
                        <div class="relative h-48 mb-6 overflow-hidden rounded-2xl shadow-sm">
                            <img src="https://i.pinimg.com/1200x/ab/66/2c/ab662c987843c90498349d84d90fa8eb.jpg"
                                alt="Insomnia Akibat Gadget"
                                class="object-cover w-full h-full transform group-hover:scale-110 transition duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                        </div>

                        <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-teal-600 transition-colors">
                            Gangguan Tidur</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Cahaya gadget menekan hormon melatonin di malam hari, menyebabkan insomnia dan menurunkan
                            kualitas pemulihan sel mata.
                        </p>
                    </div>

                </div>




                {{-- Banner Call to Action --}}
                <div class="mt-20 relative rounded-3xl overflow-hidden bg-teal-800 text-center shadow-2xl">
                    {{-- Decorative Circle --}}
                    <div class="absolute top-0 left-0 -ml-10 -mt-10 w-40 h-40 bg-teal-600 rounded-full opacity-50"></div>
                    <div class="absolute bottom-0 right-0 -mr-10 -mb-10 w-40 h-40 bg-teal-500 rounded-full opacity-50">
                    </div>

                    <div class="relative z-10 px-8 py-12 md:py-16">
                        <h2 class="text-2xl md:text-3xl font-bold text-white mb-4">Jangan Abaikan Sinyal Tubuh Anda</h2>
                        <p class="text-teal-100 mb-8 text-lg max-w-2xl mx-auto">
                            Pencegahan lebih baik daripada pengobatan. Cek kondisi mata Anda sekarang dengan sistem pakar
                            kami.
                        </p>
                        <a href="{{ route('pertanyaan') }}"
                            class="inline-flex items-center bg-white text-teal-800 px-8 py-3 rounded-full font-bold hover:bg-teal-50 hover:scale-105 transition-all duration-300 shadow-lg">
                            Cek Gejala Sekarang <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </main>

@endsection