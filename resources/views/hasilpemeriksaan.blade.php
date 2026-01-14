@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center p-6 print:p-0"
        style="background: linear-gradient(135deg, #D7E7E5 0%, #B8D4D1 100%);">

        {{-- Container Utama --}}
        <div class="max-w-4xl w-full print:max-w-full print:w-full">

            {{-- Main Result Modal --}}
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden transform transition-all duration-500 opacity-0 translate-y-4 print:shadow-none print:transform-none print:opacity-100 print:translate-y-0"
                id="result-card">

                {{-- Header Print (Muncul hanya saat print) --}}
                <div class="hidden print:block text-center pt-6 pb-2 border-b-2 border-teal-500 mb-4">
                    <h1 class="text-2xl font-bold text-teal-800">HASIL DIAGNOSA MATA</h1>
                    <p class="text-sm text-gray-500">Sistem Pakar Diagnosa Penyakit Mata (CVS)</p>
                </div>

                {{-- Close Button (Hilang saat Print) --}}
                <div class="flex justify-end p-4 no-print">
                    <button onclick="window.location.href='/'"
                        class="text-gray-400 hover:text-gray-600 transition-colors p-2 hover:bg-gray-100 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Result Section --}}
                <div class="px-8 pb-8 print:px-4 print:pb-2">
                    
                    {{-- Layout Atas: Kiri (Lingkaran) & Kanan (Info/Saran) untuk Print --}}
                    <div class="print:flex print:items-start print:gap-6 print:mb-4">
                        
                        {{-- Kolom Visual (Lingkaran) --}}
                        <div class="relative print:w-1/3 print:flex print:flex-col print:items-center">
                            {{-- Progress Circle --}}
                            <div class="flex items-center justify-center mb-6 print:mb-2">
                                <div class="relative w-48 h-48 print:w-32 print:h-32">
                                    <svg class="transform -rotate-90 w-48 h-48 print:w-32 print:h-32">
                                        <circle cx="50%" cy="50%" r="45%" stroke="#E5E7EB" stroke-width="10%" fill="none" />
                                        <circle id="progress-circle" cx="50%" cy="50%" r="45%"
                                            stroke="{{ $diagnosis['color'] === 'red' ? '#EF4444' : ($diagnosis['color'] === 'orange' ? '#F97316' : ($diagnosis['color'] === 'yellow' ? '#EAB308' : '#10B981')) }}"
                                            stroke-width="10%" fill="none" stroke-linecap="round" stroke-dasharray="552"
                                            stroke-dashoffset="552" class="transition-all duration-2000 ease-out"
                                            style="filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1))" />
                                    </svg>

                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <div class="text-center">
                                            <span id="percentage-value"
                                                class="text-5xl font-bold bg-gradient-to-r from-teal-600 to-teal-800 bg-clip-text text-transparent print:text-3xl print:text-teal-800">
                                                0%
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Diagnosis Badge --}}
                            <div class="text-center mb-6 print:mb-0">
                                <span class="inline-flex items-center px-6 py-2 rounded-full text-sm font-semibold opacity-0 translate-y-2 transition-all duration-500 print:opacity-100 print:translate-y-0 print:border print:border-gray-300 print:px-3 print:py-1"
                                    id="diagnosis-badge"
                                    style="background-color: {{ $diagnosis['color'] === 'red' ? 'rgb(254 226 226)' : ($diagnosis['color'] === 'orange' ? 'rgb(255 237 213)' : ($diagnosis['color'] === 'yellow' ? 'rgb(254 249 195)' : 'rgb(220 252 231)')) }}; 
                                           color: {{ $diagnosis['color'] === 'red' ? 'rgb(153 27 27)' : ($diagnosis['color'] === 'orange' ? 'rgb(154 52 18)' : ($diagnosis['color'] === 'yellow' ? 'rgb(133 77 14)' : 'rgb(22 101 52)')) }};">
                                    {{ $diagnosis['level'] }}
                                </span>
                            </div>
                        </div>

                        {{-- Kolom Kanan (Saran) untuk Print --}}
                        <div class="print:w-2/3 print:text-sm">
                            {{-- Saran dari Database --}}
                            @if(isset($saran) && $saran)
                                <div class="bg-gradient-to-r from-teal-50 to-cyan-50 border-l-4 border-teal-500 rounded-lg p-6 mb-6 opacity-0 translate-y-2 transition-all duration-500 print:opacity-100 print:translate-y-0 print:p-3 print:mb-2 print:bg-white print:border-l-2"
                                    id="saran-box">
                                    <div class="flex items-start">
                                        <svg class="w-6 h-6 text-teal-600 mr-3 flex-shrink-0 mt-1 print:w-4 print:h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                        </svg>
                                        <div>
                                            <h4 class="font-semibold text-gray-800 mb-2 print:mb-1 print:text-teal-700">SARAN DOKTER/PAKAR:</h4>
                                            <p class="text-gray-700 leading-relaxed text-justify print:text-xs print:leading-snug">{{ $saran->isi_saran }}</p>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="bg-gradient-to-r from-yellow-50 to-orange-50 border-l-4 border-yellow-500 rounded-lg p-6 mb-6 opacity-0 translate-y-2 transition-all duration-500 print:opacity-100 print:translate-y-0 print:p-3 print:bg-white"
                                    id="saran-box">
                                    <div class="flex items-start">
                                        {{-- Icon Warning --}}
                                        <div>
                                            <h4 class="font-semibold text-gray-800 mb-2">Info</h4>
                                            <p class="text-gray-700 leading-relaxed print:text-xs">
                                                Saran belum tersedia untuk tingkat <strong>{{ $diagnosis['level'] }}</strong>.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Info Pasien (Dipindah ke tengah agar compact saat print) --}}
                    <div class="bg-gray-50 px-8 py-6 border-t border-b border-gray-200 print:bg-white print:px-0 print:py-2 print:border-y-2 print:border-gray-300 print:mb-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm print:grid-cols-3 print:gap-2">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-teal-100 rounded-full flex items-center justify-center mr-3 print:hidden">
                                    <i class="fas fa-user text-teal-600"></i>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-xs uppercase tracking-wide">Nama Pasien</p>
                                    <p class="font-semibold text-gray-700 print:text-sm">{{ $pemeriksaan->user->name ?? 'Tidak diketahui' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3 print:hidden">
                                    <i class="fas fa-birthday-cake text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-xs uppercase tracking-wide">Usia</p>
                                    <p class="font-semibold text-gray-700 print:text-sm">{{ $pemeriksaan->user->umur ?? 'Tidak diketahui' }} tahun</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mr-3 print:hidden">
                                    <i class="fas fa-calendar-alt text-purple-600"></i>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-xs uppercase tracking-wide">Tanggal Cek</p>
                                    <p class="font-semibold text-gray-700 print:text-sm">{{ $pemeriksaan->tanggal->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Detail Gejala --}}
                    @if($jawabanGejala->isNotEmpty())
                        <div class="print:mt-2">
                            {{-- Header Detail Gejala (Khusus Print) --}}
                            <div class="hidden print:block mb-2">
                                <h3 class="font-bold text-gray-800 text-sm border-b border-gray-300 pb-1">DETAIL GEJALA YANG TERDETEKSI:</h3>
                            </div>

                            {{-- Tombol Toggle (Hilang saat Print) --}}
                            <button onclick="toggleDetail()"
                                class="w-full flex items-center justify-between p-4 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors border border-gray-200 no-print">
                                <span class="font-semibold text-gray-700 flex items-center">
                                    <i class="fas fa-list-ul mr-2 text-teal-600"></i>
                                    Lihat Detail Gejala ({{ $jawabanGejala->count() }} gejala terdeteksi)
                                </span>
                                <svg id="arrow-icon" class="w-5 h-5 text-gray-600 transform transition-transform duration-300"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            {{-- List Gejala --}}
                            {{-- Tambahkan class 'print-grid' agar menjadi 2 kolom saat print --}}
                            <div id="detail-section" class="hidden mt-4 space-y-3 max-h-96 overflow-y-auto print:block print:max-h-none print:overflow-visible print:mt-1 print:space-y-0 print:grid print:grid-cols-2 print:gap-2">
                                @foreach($jawabanGejala as $index => $jawab)
                                    <div class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow-md transition-all duration-300 transform hover:-translate-y-1 print:p-2 print:border-gray-300 print:shadow-none print:transform-none print:rounded-md print:flex print:flex-col"
                                        style="animation: slideInUp 0.3s ease-out {{ $index * 50 }}ms both">
                                        
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <div class="flex items-center gap-2 mb-2 print:mb-1">
                                                    <span class="text-xs font-mono bg-teal-100 text-teal-800 px-2 py-1 rounded font-semibold print:bg-gray-200 print:text-black">
                                                        {{ optional($jawab->gejala)->kode_gejala ?? '-' }}
                                                    </span>
                                                    <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded print:hidden">
                                                        CF: {{ number_format($jawab->nilai_cf, 3) }}
                                                    </span>
                                                </div>
                                                <p class="text-sm text-gray-700 font-medium mb-1 print:text-xs print:font-bold print:leading-tight">
                                                    {{ optional($jawab->gejala)->deskripsi ?? 'Gejala tidak tersedia' }}
                                                </p>
                                                <p class="text-xs text-gray-500 flex items-center print:text-[10px]">
                                                    <span class="no-print mr-1"><i class="fas fa-comment-dots"></i></span>
                                                    Jawaban: <span class="font-semibold ml-1 text-teal-700 print:text-black">{{ $jawab->jawaban_text }}</span>
                                                </p>
                                            </div>
                                            
                                            {{-- Mini Circle CF (Disembunyikan saat print agar hemat tempat) --}}
                                            <div class="w-16 h-16 flex-shrink-0 ml-4 print:hidden">
                                                <svg class="w-full h-full transform -rotate-90">
                                                    <circle cx="32" cy="32" r="28" stroke="#E5E7EB" stroke-width="4" fill="none" />
                                                    <circle class="gejala-circle" cx="32" cy="32" r="28" stroke="#14B8A6"
                                                        stroke-width="4" fill="none" stroke-dasharray="176" stroke-dashoffset="176"
                                                        stroke-linecap="round"
                                                        data-target="{{ 176 - (176 * ($jawab->nilai_cf / 0.8)) }}" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

               {{-- Action Buttons (Hilang saat Print) --}}
                <div class="px-8 py-6 bg-white border-t border-gray-200 no-print">
                    {{-- PERBAIKAN: Tambahkan 'flex-wrap' agar tombol turun jika sempit, dan 'gap-4' --}}
                    <div class="flex flex-col sm:flex-row flex-wrap gap-4 justify-center items-center">
                        
                        <a href="{{ route('pertanyaan') }}"
                            class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-white text-teal-600 font-medium rounded-lg border-2 border-teal-600 hover:bg-teal-50 transition-all duration-300 shadow-sm hover:shadow-md">
                            <i class="fas fa-redo mr-2"></i>
                            Tes Ulang
                        </a>

                        <button onclick="window.print()"
                            class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-gray-600 text-white font-medium rounded-lg hover:bg-gray-700 transition-all duration-300 shadow-sm hover:shadow-md">
                            <i class="fas fa-print mr-2"></i>
                            Cetak Hasil
                        </button>

                        <a href="/"
                            class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-medium rounded-lg hover:from-teal-600 hover:to-teal-700 transition-all duration-300 shadow-sm hover:shadow-md">
                            <i class="fas fa-home mr-2"></i>
                            Kembali ke Beranda
                        </a>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Styles Print PDF--}}
    <style>
        @keyframes slideInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        #detail-section::-webkit-scrollbar { width: 6px; }
        #detail-section::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
        #detail-section::-webkit-scrollbar-thumb { background: #14B8A6; border-radius: 10px; }
        #detail-section::-webkit-scrollbar-thumb:hover { background: #0D9488; }

     
        @media print {
            @page {
                size: A4;
                margin: 0.5cm; 
            }

            body {
                background: white !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                padding: 0 !important;
                margin: 0 !important;
                font-size: 12px; 
            }

            body * {
                visibility: hidden;
            }

            #result-card, #result-card * {
                visibility: visible;
            }
            #result-card {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                margin: 0;
                padding: 0;
                box-shadow: none !important;
                border: none !important;
            }

            .no-print {
                display: none !important;
            }

            #detail-section {
                display: grid !important;
                grid-template-columns: 1fr 1fr; 
                gap: 8px !important;
                max-height: none !important;
                overflow: visible !important;
                margin-top: 5px !important;
            }

            .bg-white, .rounded-lg, #saran-box, .grid > div {
                break-inside: avoid;
            }

            #percentage-value {
                color: #0f766e !important;
                background: none !important;
                -webkit-text-fill-color: #0f766e !important;
            }

            #diagnosis-badge, #saran-box, span {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            * {
                animation: none !important;
                transition: none !important;
                opacity: 1 !important;
                transform: none !important;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const targetPercentage = {{ $pemeriksaan->persentase_cf }};

            setTimeout(() => {
                const card = document.getElementById('result-card');
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 100);

            setTimeout(() => {
                animatePercentage(targetPercentage);
            }, 500);

            setTimeout(() => {
                const circle = document.getElementById('progress-circle');
                const circumference = 552;
                const offset = circumference - (circumference * targetPercentage / 100);
                circle.style.strokeDashoffset = offset;
            }, 600);

            setTimeout(() => {
                const badge = document.getElementById('diagnosis-badge');
                badge.style.opacity = '1';
                badge.style.transform = 'translateY(0)';
            }, 1000);

            setTimeout(() => {
                const saranBox = document.getElementById('saran-box');
                if (saranBox) {
                    saranBox.style.opacity = '1';
                    saranBox.style.transform = 'translateY(0)';
                }
            }, 1200);
        });

        function animatePercentage(target) {
            const element = document.getElementById('percentage-value');
            let current = 0;
            const increment = target / 60;
            const duration = 1500;
            const frameTime = duration / 60;
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                element.textContent = Math.round(current) + '%';
            }, frameTime);
        }

        function toggleDetail() {
            const detailSection = document.getElementById('detail-section');
            const arrowIcon = document.getElementById('arrow-icon');
            if (detailSection.classList.contains('hidden')) {
                detailSection.classList.remove('hidden');
                arrowIcon.style.transform = 'rotate(180deg)';
                // Trigger animasi lingkaran kecil
                setTimeout(() => {
                    const circles = document.querySelectorAll('.gejala-circle');
                    circles.forEach((circle, index) => {
                        const target = circle.getAttribute('data-target');
                        // Reset dulu agar animasi jalan
                        circle.style.transition = 'none';
                        circle.style.strokeDashoffset = '176';
                        setTimeout(() => {
                            circle.style.transition = 'stroke-dashoffset 0.8s ease-out';
                            circle.style.strokeDashoffset = target;
                        }, 50);
                    });
                }, 100);
            } else {
                detailSection.classList.add('hidden');
                arrowIcon.style.transform = 'rotate(0deg)';
            }
        }
    </script>
@endsection