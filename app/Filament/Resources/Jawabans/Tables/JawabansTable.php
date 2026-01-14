<?php

namespace App\Filament\Resources\Jawabans\Tables;

use Filament\Actions\ViewAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn; // Pastikan pakai TextColumn


class JawabansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // Kolom 1: Nama Pasien
                // Pastikan pakai TextColumn, JANGAN TextEntry
                TextColumn::make('pemeriksaan.user.name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('pemeriksaan.user.email')
                    ->label('Email Pasien')
                    ->searchable()
                    ->sortable()
                    ->color('gray'),

                // Kolom 2: Tanggal Pemeriksaan
                TextColumn::make('pemeriksaan.created_at')
                    ->label('Tgl Pemeriksaan')
                    ->date('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                // Filter kosongkan dulu
            ])
            ->actions([
                // Tombol "Mata" untuk melihat detail
                // Saat diklik, dia akan memanggil 'infolist' dari Resource
                ViewAction::make()
                    ->label('Lihat Detail')
                    ->modalHeading('Hasil Diagnosa'), 
            ])
            ->bulkActions([
                // Kosongkan agar aman
            ]);
    }
}