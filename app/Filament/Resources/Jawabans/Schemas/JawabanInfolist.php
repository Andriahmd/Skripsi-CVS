<?php

namespace App\Filament\Resources\Jawabans\Schemas;

use Filament\Schemas\Schema;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Schemas\Components\Section;

class JawabanInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1) 
            ->components([
                // === KARTU 1: DATA PASIEN ===
                Section::make('Informasi Pemeriksaan')
                    ->icon('heroicon-m-clipboard-document-list')
                    // UBAH JADI 3 KOLOM AGAR RAPI (Nama | Email | Tanggal)
                    ->columns(3) 
                    ->schema([
                        // 1. Nama
                        TextEntry::make('pemeriksaan.user.name')
                            ->label('Nama')
                            ->weight('bold')
                            ->icon('heroicon-m-user'),

                        // 2. Email (INI TAMBAHANNYA)
                        TextEntry::make('pemeriksaan.user.email')
                            ->label('Email Pasien')
                            ->icon('heroicon-m-envelope')
                            ->copyable() // Biar bisa dicopy saat diklik
                            ->color('gray'),

                        // 3. Tanggal
                        TextEntry::make('pemeriksaan.created_at')
                            ->label('Waktu Pemeriksaan')
                            ->dateTime('d F Y, H:i:s')
                            ->icon('heroicon-m-clock'),
                    ]),

                // === KARTU 2: TABEL ===
                Section::make('Detail Jawaban Gejala')
                    ->schema([
                        ViewEntry::make('tabel_gejala')
                            ->view('filament.infolists.tabel-hasil-diagnosa')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}