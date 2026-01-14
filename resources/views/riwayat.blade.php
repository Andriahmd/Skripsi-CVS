@extends('layouts.app')

@section('content')
    <main class="min-h-screen bg-slate-50 pt-24 pb-20 font-sans">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- HEADER SECTION --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-10">
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                        Riwayat Pemeriksaan
                    </h1>
                    <p class="text-slate-500 mt-2 text-lg">
                        Pantau perkembangan kesehatan mata Anda dari waktu ke waktu.
                    </p>
                </div>
                {{-- Tombol Aksi Cepat (Opsional) --}}
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('pertanyaan') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-teal-600 hover:bg-teal-700 shadow-lg shadow-teal-200 transition-all duration-300 transform hover:-translate-y-1">
                        <i class="fas fa-stethoscope mr-2"></i> Diagnosa Baru
                    </a>
                </div>
            </div>

            {{-- NOTIFIKASI --}}
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" class="mb-8 flex items-center p-4 bg-emerald-50 rounded-xl border border-emerald-100 shadow-sm">
                    <div class="flex-shrink-0 bg-emerald-100 rounded-full p-2">
                        <i class="fas fa-check text-emerald-600"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-emerald-800">{{ session('success') }}</p>
                    </div>
                    <button @click="show = false" class="ml-auto text-emerald-500 hover:text-emerald-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div x-data="{ show: true }" x-show="show" class="mb-8 flex items-center p-4 bg-rose-50 rounded-xl border border-rose-100 shadow-sm">
                    <div class="flex-shrink-0 bg-rose-100 rounded-full p-2">
                        <i class="fas fa-exclamation text-rose-600"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-rose-800">{{ session('error') }}</p>
                    </div>
                    <button @click="show = false" class="ml-auto text-rose-500 hover:text-rose-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            {{-- STATS CARDS (Dashboard Widgets) --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                {{-- Card 1 --}}
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-md transition-shadow duration-300 relative overflow-hidden group">
                    <div class="absolute right-0 top-0 h-24 w-24 bg-teal-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="p-3 bg-teal-100 text-teal-600 rounded-xl">
                                <i class="fas fa-file-medical-alt text-xl"></i>
                            </div>
                            <p class="text-slate-500 font-medium">Total Diagnosa</p>
                        </div>
                        <h3 class="text-4xl font-bold text-slate-800">{{ $riwayatPemeriksaan->total() }}</h3>
                        <p class="text-xs text-slate-400 mt-2">Kali pemeriksaan dilakukan</p>
                    </div>
                </div>

                {{-- Card 2 --}}
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-md transition-shadow duration-300 relative overflow-hidden group">
                    <div class="absolute right-0 top-0 h-24 w-24 bg-blue-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="p-3 bg-blue-100 text-blue-600 rounded-xl">
                                <i class="fas fa-calendar-day text-xl"></i>
                            </div>
                            <p class="text-slate-500 font-medium">Bulan Ini</p>
                        </div>
                        <h3 class="text-4xl font-bold text-slate-800">
                            {{ $riwayatPemeriksaan->where('tanggal', '>=', now()->startOfMonth())->count() }}
                        </h3>
                        <p class="text-xs text-slate-400 mt-2">Pemeriksaan di bulan {{ now()->format('F') }}</p>
                    </div>
                </div>

                {{-- Card 3 --}}
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-md transition-shadow duration-300 relative overflow-hidden group">
                    <div class="absolute right-0 top-0 h-24 w-24 bg-indigo-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="p-3 bg-indigo-100 text-indigo-600 rounded-xl">
                                <i class="fas fa-history text-xl"></i>
                            </div>
                            <p class="text-slate-500 font-medium">Terakhir Cek</p>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800 mt-2">
                            @if($riwayatPemeriksaan->count() > 0)
                                {{ $riwayatPemeriksaan->first()->tanggal->format('d M Y') }}
                            @else
                                Belum ada
                            @endif
                        </h3>
                        <p class="text-xs text-slate-400 mt-2">Tanggal pemeriksaan terakhir</p>
                    </div>
                </div>
            </div>

            {{-- MAIN CONTENT: TABLE --}}
            @if($riwayatPemeriksaan->count() > 0)
                <div class="bg-white rounded-2xl shadow-lg shadow-slate-200/50 border border-slate-100 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full whitespace-nowrap">
                            <thead>
                                <tr class="bg-slate-50/50 border-b border-slate-100 text-left">
                                    <th class="px-6 py-5 text-xs font-bold text-slate-500 uppercase tracking-wider">No</th>
                                    <th class="px-6 py-5 text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal & Waktu</th>
                                    <th class="px-6 py-5 text-xs font-bold text-slate-500 uppercase tracking-wider">Hasil Diagnosa</th>
                                    <th class="px-6 py-5 text-xs font-bold text-slate-500 uppercase tracking-wider">Tingkat Keyakinan</th>
                                    <th class="px-6 py-5 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($riwayatPemeriksaan as $index => $item)
                                    <tr class="hover:bg-slate-50/80 transition-colors duration-200">
                                        <td class="px-6 py-4 text-sm text-slate-500">
                                            {{ $riwayatPemeriksaan->firstItem() + $index }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex flex-col">
                                                <span class="text-sm font-bold text-slate-700">{{ $item->tanggal->format('d F Y') }}</span>
                                                <span class="text-xs text-slate-400 mt-0.5">
                                                    <i class="far fa-clock mr-1"></i> {{ $item->tanggal->format('H:i') }} WIB
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            @php
                                                $styles = match($item->hasil_diagnosa) {
                                                    'Berat' => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'border' => 'border-red-100', 'icon' => 'fa-exclamation-circle'],
                                                    'Sedang' => ['bg' => 'bg-orange-50', 'text' => 'text-orange-700', 'border' => 'border-orange-100', 'icon' => 'fa-exclamation-triangle'],
                                                    'Ringan' => ['bg' => 'bg-yellow-50', 'text' => 'text-yellow-700', 'border' => 'border-yellow-100', 'icon' => 'fa-info-circle'],
                                                    default => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-100', 'icon' => 'fa-check-circle']
                                                };
                                            @endphp
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold border {{ $styles['bg'] }} {{ $styles['text'] }} {{ $styles['border'] }}">
                                                <i class="fas {{ $styles['icon'] }} mr-1.5"></i>
                                                {{ $item->hasil_diagnosa }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="w-full max-w-[140px]">
                                                <div class="flex justify-between mb-1">
                                                    <span class="text-xs font-medium text-slate-700">{{ number_format($item->persentase_cf, 1) }}%</span>
                                                </div>
                                                <div class="w-full bg-slate-100 rounded-full h-2">
                                                    <div class="h-2 rounded-full transition-all duration-500 ease-out {{ $item->persentase_cf >= 70 ? 'bg-red-500 shadow-sm shadow-red-200' : ($item->persentase_cf >= 40 ? 'bg-orange-400' : 'bg-emerald-500') }}"
                                                         style="width: {{ $item->persentase_cf }}%"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="flex items-center justify-center space-x-3">
                                                <a href="{{ route('hasil.show', $item->id) }}" 
                                                   class="group flex items-center justify-center w-8 h-8 bg-white border border-slate-200 rounded-lg text-slate-500 hover:border-teal-500 hover:text-teal-600 transition-all shadow-sm hover:shadow-md"
                                                   title="Lihat Detail" aria-label="Lihat detail pemeriksaan">
                                                    <i class="fas fa-eye text-sm" aria-hidden="true"></i>
                                                    <span class="sr-only">Lihat detail</span>
                                                </a>
                                                
                                                <form action="{{ route('riwayat.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus riwayat ini permanen?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="group flex items-center justify-center w-8 h-8 bg-white border border-slate-200 rounded-lg text-slate-500 hover:border-red-500 hover:text-red-600 transition-all shadow-sm hover:shadow-md"
                                                            title="Hapus" aria-label="Hapus riwayat">
                                                        <i class="fas fa-trash text-sm" aria-hidden="true"></i>
                                                        <span class="sr-only">Hapus riwayat</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    {{-- PAGINATION --}}
                    <div class="bg-white px-6 py-4 border-t border-slate-100">
                        {{ $riwayatPemeriksaan->links() }}
                    </div>
                </div>

            @else
                {{-- EMPTY STATE (Desain Baru) --}}
                <div class="bg-white rounded-3xl shadow-lg shadow-slate-200/50 p-12 text-center border border-dashed border-slate-300">
                    <div class="w-24 h-24 bg-teal-50 rounded-full flex items-center justify-center mx-auto mb-6 animate-pulse">
                        <i class="fas fa-notes-medical text-teal-400 text-4xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-800 mb-2">Belum Ada Riwayat</h3>
                    <p class="text-slate-500 mb-8 max-w-md mx-auto">
                        Anda belum melakukan diagnosa apapun. Data pemeriksaan kesehatan mata Anda akan muncul di sini.
                    </p>
                    <a href="{{ route('pertanyaan') }}" 
                       class="inline-flex items-center px-8 py-4 bg-teal-600 text-white font-bold rounded-xl hover:bg-teal-700 transition shadow-lg shadow-teal-200 hover:-translate-y-1">
                        <i class="fas fa-plus mr-2"></i> Mulai Diagnosa Pertama
                    </a>
                </div>
            @endif

        </div>
    </main>
@endsection