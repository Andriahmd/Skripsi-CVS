@extends('layouts.app')

@section('title', 'Saran & Tips Kesehatan Mata - MataCare')

@section('content')
    <div class="min-h-screen bg-[#D7E7E5] pt-24 pb-20">

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="text-center mb-12 animate-fade-in-down">
                <h2 class="text-teal-600 font-bold tracking-wide uppercase text-sm mb-2">Health Advice</h2>
                <h1 class="text-3xl md:text-5xl font-extrabold text-gray-900">
                    Menjaga Mata Tetap <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-600 to-emerald-600">Prima & Sehat</span>
                </h1>
                <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-600">
                    Mata adalah jendela dunia. Berikut adalah langkah praktis untuk mencegah Computer Vision Syndrome (CVS).
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <div class="group relative overflow-hidden rounded-2xl shadow-lg h-64">
                    <img src="https://images.unsplash.com/photo-1512621776951-a57141f2eefd?auto=format&fit=crop&w=800&q=80" 
                         alt="Makanan Sehat"
                         class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex items-end p-6">
                        <h3 class="text-white font-bold text-lg">Nutrisi Sehat</h3>
                    </div>
                </div>
                <div class="group relative overflow-hidden rounded-2xl shadow-lg h-64">
                    <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=800&q=80" 
                         alt="Batasi Gadget"
                         class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex items-end p-6">
                        <h3 class="text-white font-bold text-lg">Ergonomi Digital</h3>
                    </div>
                </div>
                <div class="group relative overflow-hidden rounded-2xl shadow-lg h-64">
                    <img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=800&q=80" 
                         alt="Konsultasi Dokter"
                         class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex items-end p-6">
                        <h3 class="text-white font-bold text-lg">Pemeriksaan Rutin</h3>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2 bg-white rounded-3xl shadow-xl p-8 md:p-10 border-l-8 border-teal-500">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-book-medical text-teal-600 mr-3"></i> Panduan Kesehatan Mata
                    </h3>
                    
                    <div class="prose text-gray-600 leading-relaxed">
                        <p class="mb-6 text-lg">
                            Kelelahan mata digital bukan hal sepele. Untuk menjaga mata tetap sehat, langkah pertama adalah memperhatikan asupan nutrisi. Pastikan piring Anda berisi makanan yang kaya 
                            <strong class="text-teal-700">Vitamin A, C, dan E</strong> seperti wortel, bayam, dan kacang-kacangan.
                        </p>
                        
                        <h4 class="text-xl font-bold text-gray-800 mb-3">Aturan 20-20-20</h4>
                        <p class="mb-6">
                            Ini adalah metode paling efektif mencegah CVS. Setiap <strong>20 menit</strong> menatap layar, alihkan pandangan ke objek sejauh <strong>20 kaki (6 meter)</strong> selama minimal <strong>20 detik</strong>. Ini membantu merilekskan otot fokus mata.
                        </p>

                        <h4 class="text-xl font-bold text-gray-800 mb-3">Kapan Harus ke Dokter?</h4>
                        <p>
                            Jika mata Anda terasa perih, berair terus-menerus, atau pandangan menjadi kabur bahkan setelah beristirahat, 
                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded font-semibold">SEGERA PERIKSA</span> 
                            ke tenaga medis terdekat. Jangan menunggu hingga gejala memburuk.
                        </p>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600 mb-4">
                            <i class="fas fa-carrot text-xl"></i>
                        </div>
                        <h4 class="font-bold text-gray-800 mb-2">Konsumsi Nutrisi</h4>
                        <p class="text-sm text-gray-500">Wortel, Ikan, dan Sayuran hijau adalah sahabat terbaik retina Anda.</p>
                    </div>

                    <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 mb-4">
                            <i class="fas fa-mobile-alt text-xl"></i>
                        </div>
                        <h4 class="font-bold text-gray-800 mb-2">Screen Time Management</h4>
                        <p class="text-sm text-gray-500">Kurangi kecerahan layar dan gunakan mode "Night Light" di malam hari.</p>
                    </div>

                    <div class="bg-gradient-to-br from-teal-500 to-emerald-600 rounded-2xl p-6 shadow-lg text-white relative overflow-hidden">
                        <i class="fas fa-quote-right absolute bottom-4 right-4 text-white/20 text-6xl"></i>
                        <p class="font-medium italic relative z-10">"Investasi terbaik untuk masa depan Anda adalah kesehatan mata Anda hari ini."</p>
                        <p class="text-sm mt-4 text-teal-100 font-semibold relative z-10">- Tim Dokter MataCare</p>
                    </div>
                </div>

            </div>
            
            <div class="mt-12 text-center">
                <a href="/" class="inline-flex items-center px-8 py-3 border border-transparent text-base font-medium rounded-full text-teal-700 bg-teal-100 hover:bg-teal-200 transition duration-300">
                    <i class="fas fa-home mr-2"></i> Kembali ke Beranda
                </a>
            </div>

        </div>
    </div>

    <style>
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translate3d(0, -20px, 0);
            }
            to {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
        }
        .animate-fade-in-down {
            animation: fadeInDown 0.8s ease-out;
        }
    </style>
@endsection