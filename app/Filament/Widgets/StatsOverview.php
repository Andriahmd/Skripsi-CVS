<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use App\Models\Pemeriksaan;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    
    protected function getStats(): array
    {
        // Hitung total user
        $totalUsers = User::count();
        
        // Hitung total pemeriksaan yang sudah selesai
        $totalPemeriksaan = Pemeriksaan::whereNotNull('hasil_diagnosa')->count();
        
        // Hitung pemeriksaan bulan ini
        $pemeriksaanBulanIni = Pemeriksaan::whereNotNull('hasil_diagnosa')
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->count();
        
        // Hitung pemeriksaan tingkat Berat
        $pemeriksaanBerat = Pemeriksaan::where('hasil_diagnosa', 'Berat')->count();
        
        // Hitung pemeriksaan tingkat Sedang
        $pemeriksaanSedang = Pemeriksaan::where('hasil_diagnosa', 'Sedang')->count();
        
        // Hitung pemeriksaan tingkat Ringan
        $pemeriksaanRingan = Pemeriksaan::where('hasil_diagnosa', 'Ringan')->count();

        return [
            Stat::make('Total User', $totalUsers)
                ->description('Jumlah pengguna terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),
            
            Stat::make('Total Pemeriksaan', $totalPemeriksaan)
                ->description('Pemeriksaan selesai')
                ->descriptionIcon('heroicon-m-clipboard-document-check')
                ->color('primary'),
            
            Stat::make('Pemeriksaan Bulan Ini', $pemeriksaanBulanIni)
                ->description(now()->format('F Y'))
                ->descriptionIcon('heroicon-m-calendar')
                ->color('info'),
            
            Stat::make('CVS Tingkat Berat', $pemeriksaanBerat)
                ->description('Perlu perhatian serius')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('danger'),
            
            Stat::make('CVS Tingkat Sedang', $pemeriksaanSedang)
                ->description('Perlu penanganan')
                ->descriptionIcon('heroicon-m-exclamation-circle')
                ->color('warning'),
            
            Stat::make('CVS Tingkat Ringan', $pemeriksaanRingan)
                ->description('Dalam pengawasan')
                ->descriptionIcon('heroicon-m-information-circle')
                ->color('success'),
        ];
    }
}