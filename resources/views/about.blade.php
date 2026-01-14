@extends('layouts.app')

@section('content')
{{-- Background color #D7E7E5 sesuai permintaan --}}
<section class="about-section py-16 relative" style="background-color: #D7E7E5;">
    <div class="container mx-auto px-6">
        <div class="flex flex-col lg:flex-row items-center gap-12">
            
            {{-- KOLOM KIRI: GAMBAR --}}
            {{-- Gambar dibuat responsif, dengan sedikit styling agar elegan --}}
            <div class="w-full lg:w-1/2">
                <div class="relative">
                    {{-- Dekorasi border di belakang gambar --}}
                    <div class="absolute inset-0 border-2 border-teal-600 rounded-2xl transform translate-x-3 translate-y-3 z-0"></div>
                    
                    <img src="https://i.pinimg.com/1200x/a2/20/cb/a220cb6423e96fe1754b09815880f421.jpg" 
                         alt="Computer Vision Syndrome Illustration" 
                         class="relative z-10 w-full h-auto object-cover rounded-2xl shadow-xl hover:shadow-2xl transition-shadow duration-300"
                         style="max-height: 600px;">
                </div>
            </div>
            
            {{-- KOLOM KANAN: TEKS DESKRIPTIF & CARD --}}
            <div class="w-full lg:w-1/2 lg:pl-6">
                
                {{-- Judul & Deskripsi Utama --}}
                <div class="mb-8">
                    <h4 class="text-teal-700 font-bold uppercase tracking-widest text-sm mb-2">Tentang Penyakit</h4>
                    <h1 class="text-3xl lg:text-4xl font-extrabold text-teal-900 mb-4 leading-tight">
                        Apa Itu <span class="text-teal-600">Computer Vision Syndrome?</span>
                    </h1>
                    <p class="text-gray-700 text-lg leading-relaxed text-justify">
                        <strong>Computer Vision Syndrome (CVS)</strong> adalah istilah medis untuk kumpulan gangguan pada mata dan fisik yang timbul akibat penggunaan komputer, tablet, atau ponsel dalam waktu yang lama. Berbeda dengan membaca di kertas, piksel pada layar memaksa mata bekerja ekstra keras untuk menjaga fokus, yang memicu kelelahan visual.
                    </p>
                </div>

                {{-- CARD SECTION (Menyamping di dalam kolom kanan) --}}
                <div class="space-y-6">
                    
                    {{-- Card 1: Gejala Utama --}}
                    <div class="group flex items-start bg-white/60 backdrop-blur-sm p-5 rounded-xl border border-teal-100 shadow-sm hover:shadow-md hover:bg-white transition-all duration-300">
                        {{-- Icon Wrapper --}}
                        <div class="flex-shrink-0 mr-5">
                            <div class="w-12 h-12 bg-teal-100 rounded-full flex items-center justify-center text-teal-600 group-hover:bg-teal-600 group-hover:text-white transition-colors duration-300">
                                {{-- Icon Mata (SVG) --}}
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </div>
                        </div>
                        {{-- Text Content --}}
                        <div>
                            <h3 class="text-xl font-bold text-teal-900 mb-2">Gejala Utama</h3>
                            <p class="text-gray-600 text-sm leading-relaxed">
                                Tanda awal meliputi mata merah dan kering, penglihatan menjadi kabur atau ganda, serta kesulitan memfokuskan pandangan setelah menatap layar.
                            </p>
                        </div>
                    </div>

                    {{-- Card 2: Bahaya & Dampak Fisik --}}
                    <div class="group flex items-start bg-white/60 backdrop-blur-sm p-5 rounded-xl border border-teal-100 shadow-sm hover:shadow-md hover:bg-white transition-all duration-300">
                        {{-- Icon Wrapper --}}
                        <div class="flex-shrink-0 mr-5">
                            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center text-red-500 group-hover:bg-red-500 group-hover:text-white transition-colors duration-300">
                                {{-- Icon Bahaya/Fisik (SVG) --}}
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                        </div>
                        {{-- Text Content --}}
                        <div>
                            <h3 class="text-xl font-bold text-teal-900 mb-2">Bahaya & Dampak Fisik</h3>
                            <p class="text-gray-600 text-sm leading-relaxed">
                                Jika dibiarkan, dapat memicu sakit kepala kronis (*headache*), serta nyeri pada leher dan bahu akibat postur tubuh yang buruk saat menggunakan perangkat.
                            </p>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>
@endsection