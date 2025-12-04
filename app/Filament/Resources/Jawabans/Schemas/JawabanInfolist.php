<?php

namespace App\Filament\Resources\Jawabans\Schemas;

use Filament\Schemas\Schema;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Grid;
use Filament\Schemas\Components\Grid as ComponentsGrid;

class JawabanInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                ComponentsGrid::make(2)
                    ->schema([
                        // Data User (Deep Relation lagi)
                        TextEntry::make('pemeriksaan.user.name')
                            ->label('Nama Pasien')
                            ->icon('heroicon-m-user'),

                        // Link ke Tanggal Pemeriksaan
                        TextEntry::make('pemeriksaan.tanggal')
                            ->label('Tanggal Periksa')
                            ->dateTime('d M Y, H:i'),

                        // // Data Gejala & Jawaban
                        // TextEntry::make('gejala.nama_gejala') // Sesuaikan nama kolom DB Gejala
                        //     ->label('Pertanyaan / Gejala')
                        //     ->columnSpanFull(), // Memanjang penuh ke samping

                        TextEntry::make('jawaban_text')
                            ->label('Jawaban')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'Selalu' => 'danger',
                                'Cukup Sering' => 'warning',
                                'Kadang-kadang' => 'info',
                                default => 'success',
                            }),

                        TextEntry::make('nilai_cf')
                            ->label('Bobot CF')
                            ->weight('bold'),
                    ]),
            ]);
    }
}