<?php

namespace App\Filament\Resources\InklusiEksklusis\Schemas;

use Filament\Schemas\Schema;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\IconEntry;
use Filament\Schemas\Components\Grid as ComponentsGrid;

class InklusiEksklusiInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                ComponentsGrid::make(2)
                    ->schema([
                        // Data Pasien
                        TextEntry::make('pemeriksaan.user.name')
                            ->label('Nama Pasien')
                            ->icon('heroicon-m-user'),

                        TextEntry::make('pemeriksaan.tanggal')
                            ->label('Tanggal Screening')
                            ->dateTime('d F Y, H:i'),
                        
                        // Status Inklusi (Menggunakan Icon Check/X)
                        IconEntry::make('memenuhi_inklusi')
                            ->label('Memenuhi Kriteria Inklusi?')
                            ->boolean() // Otomatis jadi Centang/Silang
                            ->trueColor('success')
                            ->falseColor('danger'),

                        // Status Eksklusi
                        IconEntry::make('ada_eksklusi')
                            ->label('Ditemukan Kriteria Eksklusi?')
                            ->boolean()
                            ->trueColor('danger') // Kalau True (Ada Eksklusi) malah Merah
                            ->falseColor('success'), // Kalau False (Tidak ada Eksklusi) malah Hijau
                    ]),
            ]);
    }
}