<?php

namespace App\Filament\Resources\InklusiEksklusis\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Actions\ViewAction;

class InklusiEksklusisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // 1. Menampilkan Nama Pasien (Relasi Berjenjang)
                TextColumn::make('pemeriksaan.user.name')
                    ->label('Nama Pasien')
                    ->searchable()
                    ->sortable(),

                // 2. Menampilkan Tanggal Pemeriksaan
                TextColumn::make('pemeriksaan.tanggal')
                    ->label('Tanggal')
                    ->dateTime('d M Y')
                    ->sortable(),

                // 3. Status Inklusi (Kriteria Masuk)
                TextColumn::make('memenuhi_inklusi')
                    ->label('Memenuhi Inklusi?')
                    ->badge()
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Ya' : 'Tidak')
                    ->color(fn (bool $state): string => $state ? 'success' : 'danger'),

                // 4. Status Eksklusi (Kriteria Penolak)
                // Hati-hati: Eksklusi "Ya" (True) justru artinya buruk (Danger)
                TextColumn::make('ada_eksklusi')
                    ->label('Ada Eksklusi?')
                    ->badge()
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Ya' : 'Tidak')
                    ->color(fn (bool $state): string => $state ? 'danger' : 'success'),

                // 5. Status Akhir (Opsional: Computed Column)
                // Menghitung logika sederhana: Lolos jika Inklusi YA dan Eksklusi TIDAK
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
            ->filters([
                // Filter status lolos/tidak
            ])
            ->actions([
                // // HANYA VIEW
                // ViewAction::make(),
            ])
            ->bulkActions([
                // Kosongkan agar aman
            ]);
    }
}