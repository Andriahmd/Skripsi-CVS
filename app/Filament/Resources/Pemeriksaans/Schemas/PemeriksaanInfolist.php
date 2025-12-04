<?php

namespace App\Filament\Resources\Pemeriksaans\Schemas;

use Filament\Schemas\Schema;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Grid;
use Filament\Schemas\Components\Section as ComponentsSection;
use Filament\Tables\Columns\Layout\Grid as LayoutGrid;

class PemeriksaanInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                ComponentsSection::make('Informasi Pasien & Waktu')
                    ->schema([
                        LayoutGrid::make(2)
                            ->schema([
                                TextEntry::make('user.name')
                                    ->label('Nama Pasien'),
                                TextEntry::make('user.email')
                                    ->label('Email'),
                                TextEntry::make('tanggal')
                                    ->dateTime('d F Y H:i:s')
                                    ->label('Waktu Pemeriksaan'),
                            ]),
                    ]),

                ComponentsSection::make('Hasil Diagnosa')
                    ->schema([
                        LayoutGrid::make(2)
                            ->schema([
                                TextEntry::make('hasil_diagnosa')
                                    ->label('Hasil')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'Normal' => 'success',
                                        'Sangat Berat' => 'danger',
                                        default => 'warning',
                                    })
                                    ->size('lg'), // Ukuran teks lebih besar
                                
                                TextEntry::make('persentase_cf')
                                    ->label('Tingkat Keyakinan (CF)')
                                    ->numeric(2)
                                    ->suffix('%')
                                    ->size('lg'),
                            ]),
                    ]),
            ]);
    }
}