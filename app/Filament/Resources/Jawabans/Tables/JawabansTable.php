<?php

namespace App\Filament\Resources\Jawabans\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Filters\SelectFilter;

class JawabansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                
                TextColumn::make('pemeriksaan.user.name')
                    ->label('Nama Pasien')
                    ->searchable() // Bisa dicari berdasarkan nama
                    ->sortable(),

                // TextColumn::make('gejala.nama_gejala') 
                //     ->label('Gejala')
                //     ->wrap() // Agar teks panjang turun ke bawah (tidak melebar)
                //     ->limit(50),

                // 3. Jawaban User dengan Warna (Badge)
                TextColumn::make('jawaban_text')
                    ->label('Jawaban')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Selalu' => 'danger',       // Merah
                        'Cukup Sering' => 'warning', // Kuning/Oranye
                        'Kadang-kadang' => 'info',   // Biru
                        'Tidak Pernah' => 'success', // Hijau
                        default => 'gray',
                    }),

                // 4. Nilai CF
                TextColumn::make('nilai_cf')
                    ->label('Nilai CF')
                    ->numeric(1) // 1 angka belakang koma
                    ->sortable(),
            ])
            ->filters([
                // Opsional: Filter berdasarkan Jawaban Text
                SelectFilter::make('jawaban_text')
                    ->options([
                        'Selalu' => 'Selalu',
                        'Cukup Sering' => 'Cukup Sering',
                        'Kadang-kadang' => 'Kadang-kadang',
                        'Tidak Pernah' => 'Tidak Pernah',
                    ]),
            ])
            ->actions([
                
                
            ])
            ->bulkActions([
                // Kosongkan agar admin tidak bisa hapus massal
            ]);
    }
}