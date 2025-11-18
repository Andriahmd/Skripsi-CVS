{{-- resources/views/hasilpemeriksaan.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center p-6" style="background: linear-gradient(135deg, #D7E7E5 0%, #B8D4D1 100%);">
    
    <!-- Modal Result Container -->
    <div class="max-w-4xl w-full">
        
        <!-- Main Result Modal -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden transform transition-all duration-500 animate-slideUp">
            
            <!-- Close Button -->
            <div class="flex justify-end p-4">
                <button onclick="window.location.href='/'" 
                    class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0Coba lagiAALanjutkanblade{{-- resources/views/hasilpemeriksaan.blade.php (CONTINUED) --}}
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

           
            <!-- Persentase Result -->
            <div class="px-8 pb-8">
                <div class="relative">
                    <!-- Progress Circle Background -->
                    <div class="flex items-center justify-center mb-6">
                        <div class="relative w-48 h-48">
                            <!-- Background Circle -->
                            <svg class="transform -rotate-90 w-48 h-48">
                                <circle cx="96" cy="96" r="88" stroke="#E5E7EB" stroke-width="12" fill="none"/>
                                <!-- Progress Circle -->
                                <circle cx="96" cy="96" r="88" 
                                    stroke="{{ $diagnosis['color'] === 'red' ? '#EF4444' : ($diagnosis['color'] === 'orange' ? '#F97316' : ($diagnosis['color'] === 'yellow' ? '#EAB308' : ($diagnosis['color'] === 'blue' ? '#3B82F6' : '#10B981'))) }}" 
                                    stroke-width="12" 
                                    fill="none"
                                    stroke-linecap="round"
                                    stroke-dasharray="552"
                                    stroke-dashoffset="{{ 552 - (552 * $pemeriksaan->persentase_cf / 100) }}"
                                    class="transition-all duration-1000 ease-out"
                                    style="filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1))"/>
                            </svg>
                            
                            <!-- Percentage Text -->
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="text-center">
                                    <span class="text-5xl font-bold bg-gradient-to-r from-teal-600 to-teal-800 bg-clip-text text-transparent">
                                        {{ number_format($pemeriksaan->persentase_cf, 1) }}%
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Diagnosis Level Badge -->
                    <div class="text-center mb-6">
                        <span class="inline-flex items-center px-6 py-2 rounded-full text-sm font-semibold
                            {{ $diagnosis['color'] === 'red' ? 'bg-red-100 text-red-800' : 
                               ($diagnosis['color'] === 'orange' ? 'bg-orange-100 text-orange-800' : 
                               ($diagnosis['color'] === 'yellow' ? 'bg-yellow-100 text-yellow-800' : 
                               ($diagnosis['color'] === 'blue' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800'))) }}">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Tingkat: {{ $diagnosis['level'] }}
                        </span>
                    </div>

                    <!-- Keterangan -->
                    <div class="bg-gradient-to-r from-teal-50 to-cyan-50 border-l-4 border-teal-500 rounded-lg p-6 mb-6">
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-teal-600 mr-3 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <h4 class="font-semibold text-gray-800 mb-1">Keterangan</h4>
                                <p class="text-gray-700 leading-relaxed">{{ $diagnosis['keterangan'] }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Rekomendasi -->
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-blue-500 rounded-lg p-6 mb-6">
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-blue-600 mr-3 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                            <div>
                                <h4 class="font-semibold text-gray-800 mb-1">Rekomendasi</h4>
                                <p class="text-gray-700 leading-relaxed">{{ $diagnosis['rekomendasi'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Gejala Section -->
            @if($jawabanGejala->isNotEmpty())
            <div class="px-8 pb-8">
                <button onclick="toggleDetail()" 
                    class="w-full flex items-center justify-between p-4 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors border border-gray-200">
                    <span class="font-semibold text-gray-700">Lihat Detail Gejala ({{ $jawabanGejala->count() }} gejala terdeteksi)</span>
                    <svg id="arrow-icon" class="w-5 h-5 text-gray-600 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div id="detail-section" class="hidden mt-4 space-y-3 max-h-96 overflow-y-auto">
                    @foreach($jawabanGejala as $index => $jawab)
                    <div class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="text-xs font-mono bg-teal-100 text-teal-800 px-2 py-1 rounded">
                                        {{ optional($jawab->gejala)->kode_gejala ?? '-' }}
                                    </span>
                                    <span class="text-xs text-gray-500">CF: {{ number_format($jawab->nilai_cf, 3) }}</span>
                                </div>
                                <p class="text-sm text-gray-700 font-medium">
                                    {{ optional($jawab->gejala)->deskripsi ?? 'Gejala tidak tersedia' }}
                                </p>
                                <p class="text-xs text-gray-500 mt-1">Jawaban: {{ $jawab->jawaban_text }}</p>
                            </div>
                            <div class="w-16 h-16 flex-shrink-0 ml-4">
                                <svg class="w-full h-full transform -rotate-90">
                                    <circle cx="32" cy="32" r="28" stroke="#E5E7EB" stroke-width="4" fill="none"/>
                                    <circle cx="32" cy="32" r="28" 
                                        stroke="#14B8A6" 
                                        stroke-width="4" 
                                        fill="none"
                                        stroke-dasharray="176"
                                        stroke-dashoffset="{{ 176 - (176 * ($jawab->nilai_cf / 0.8)) }}"
                                        stroke-linecap="round"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Info Pasien -->
            <div class="bg-gray-50 px-8 py-6 border-t border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <div>
                            <p class="text-gray-500 text-xs">Nama Pasien</p>
                            <p class="font-semibold text-gray-700">{{ $pemeriksaan->user->name ?? 'Tidak diketahui' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <p class="text-gray-500 text-xs">Usia</p>
                            <p class="font-semibold text-gray-700">{{ $pemeriksaan->user->umur ?? 'Tidak diketahui' }} tahun</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <div>
                            <p class="text-gray-500 text-xs">Tanggal Pemeriksaan</p>
                            <p class="font-semibold text-gray-700">{{ $pemeriksaan->tanggal->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="px-8 py-6 bg-white border-t border-gray-200">
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('pertanyaan') }}" 
                        class="inline-flex items-center justify-center px-6 py-3 bg-white text-teal-600 font-medium rounded-lg border-2 border-teal-600 hover:bg-teal-50 transition-all duration-300 shadow-sm hover:shadow-md">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Tes Ulang
                    </a>
                    
                    <button onclick="window.print()" 
                        class="inline-flex items-center justify-center px-6 py-3 bg-gray-600 text-white font-medium rounded-lg hover:bg-gray-700 transition-all duration-300 shadow-sm hover:shadow-md">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                        </svg>
                        Cetak Hasil
                    </button>
                    
                    <a href="/" 
                        class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-medium rounded-lg hover:from-teal-600 hover:to-teal-700 transition-all duration-300 shadow-sm hover:shadow-md">
                        Kembali ke Beranda
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-slideUp {
        animation: slideUp 0.5s ease-out;
    }

    /* Print styles */
    @media print {
        body * {
            visibility: hidden;
        }
        .max-w-4xl, .max-w-4xl * {
            visibility: visible;
        }
        .max-w-4xl {
            position: absolute;
            left: 0;
            top: 0;
        }
        button {
            display: none !important;
        }
    }

    /* Custom scrollbar untuk detail section */
    #detail-section::-webkit-scrollbar {
        width: 6px;
    }
    
    #detail-section::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    #detail-section::-webkit-scrollbar-thumb {
        background: #14B8A6;
        border-radius: 10px;
    }
    
    #detail-section::-webkit-scrollbar-thumb:hover {
        background: #0D9488;
    }
</style>

<script>
    function toggleDetail() {
        const detailSection = document.getElementById('detail-section');
        const arrowIcon = document.getElementById('arrow-icon');
        
        if (detailSection.classList.contains('hidden')) {
            detailSection.classList.remove('hidden');
            arrowIcon.style.transform = 'rotate(180deg)';
        } else {
            detailSection.classList.add('hidden');
            arrowIcon.style.transform = 'rotate(0deg)';
        }
    }

    // Animasi progress circle saat load
    window.addEventListener('load', function() {
        const circle = document.querySelector('circle[stroke-dashoffset]');
        if (circle) {
            circle.style.transition = 'stroke-dashoffset 1.5s ease-out';
        }
    });
</script>
@endsection