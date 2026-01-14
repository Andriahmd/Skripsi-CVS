<?php

namespace App\Filament\Resources\Sarans\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class SaranInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id_saran')
                    ->label('ID Saran')
                    ->badge()
                    ->color('gray'),
                
                TextEntry::make('kategori')
                    ->label('Kategori CVS')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Tidak Mengalami' => 'success',
                        'Ringan' => 'warning',
                        'Sedang' => 'danger',
                        'Berat' => 'danger',
                        default => 'gray',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'Tidak Mengalami' => 'heroicon-o-check-circle',
                        'Ringan' => 'heroicon-o-exclamation-circle',
                        'Sedang' => 'heroicon-o-exclamation-triangle',
                        'Berat' => 'heroicon-o-x-circle',
                        default => 'heroicon-o-information-circle',
                    }),
                
                TextEntry::make('range_persentase')
                    ->label('Range Persentase')
                    ->getStateUsing(fn ($record) => $record->persentase_min . '% - ' . $record->persentase_max . '%')
                    ->badge()
                    ->color('info')
                    ->icon('heroicon-o-chart-bar'),
                
                TextEntry::make('persentase_min')
                    ->label('Persentase Minimum')
                    ->numeric(decimalPlaces: 2)
                    ->suffix('%')
                    ->icon('heroicon-o-arrow-down'),
                
                TextEntry::make('persentase_max')
                    ->label('Persentase Maksimum')
                    ->numeric(decimalPlaces: 2)
                    ->suffix('%')
                    ->icon('heroicon-o-arrow-up'),
                
                TextEntry::make('isi_saran')
                    ->label('Saran untuk Pasien')
                    ->columnSpanFull()
                    ->prose(),
                
                TextEntry::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d F Y, H:i:s')
                    ->placeholder('-')
                    ->icon('heroicon-o-calendar')
                    ->color('success'),
                
                TextEntry::make('updated_at')
                    ->label('Terakhir Diperbarui')
                    ->dateTime('d F Y, H:i:s')
                    ->placeholder('-')
                    ->icon('heroicon-o-clock')
                    ->color('warning'),
            ])
            ->columns(3);
    }
}