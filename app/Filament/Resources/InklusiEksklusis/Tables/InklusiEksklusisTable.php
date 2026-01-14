<?php

namespace App\Filament\Resources\InklusiEksklusis\Tables;

use Filament\Actions\ViewAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;


class InklusiEksklusisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // 1. Menampilkan Nama Pasien (Relasi Berjenjang)
                TextColumn::make('pemeriksaan.user.name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                // 2. Menampilkan Tanggal Pemeriksaan
                TextColumn::make('pemeriksaan.tanggal')
                    ->label('Tanggal')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),

                // 3. Status Inklusi (Kriteria Masuk)
                TextColumn::make('memenuhi_inklusi')
                    ->label('Memenuhi Inklusi?')
                    ->badge()
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Ya' : 'Tidak')
                    ->color(fn (bool $state): string => $state ? 'success' : 'danger'),

                // 4. Status Eksklusi (Kriteria Penolak)
                TextColumn::make('ada_eksklusi')
                    ->label('Ada Eksklusi?')
                    ->badge()
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Ya' : 'Tidak')
                    ->color(fn (bool $state): string => $state ? 'danger' : 'success'),
                // 5. Status Akhir
                TextColumn::make('status_screening')
                    ->label('Status Screening')
                    ->state(function ($record) {
                        return ($record->memenuhi_inklusi && !$record->ada_eksklusi) 
                            ? 'Lolos' 
                            : 'Ditolak';
                    })
                    ->badge()
                    ->color(fn (string $state): string => $state === 'Lolos' ? 'success' : 'danger'),
            ])
            ->defaultSort('pemeriksaan.tanggal', 'desc') 
            ->filters([
            ])
            ->actions([
                ViewAction::make(),
            ])
            ->bulkActions([
            ]);
    }
}