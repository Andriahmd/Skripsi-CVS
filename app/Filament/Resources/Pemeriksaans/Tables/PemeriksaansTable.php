<?php

namespace App\Filament\Resources\Pemeriksaans\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\DeleteAction;


class PemeriksaansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // Menampilkan urutan nomor (opsional)
                TextColumn::make('rowIndex')
                    ->label('No')
                    ->rowIndex(),

                // Menampilkan Nama User (Relasi ke tabel users)
                TextColumn::make('user.name') 
                    ->label('Nama Pasien')
                    ->searchable()
                    ->sortable(),

                // Menampilkan Tanggal
                TextColumn::make('tanggal')
                    ->label('Tanggal Periksa')
                    ->dateTime('d M Y, H:i') // Format tanggal Indonesia
                    ->sortable(),

                // Menampilkan Hasil Diagnosa dengan warna (Badge)
                TextColumn::make('hasil_diagnosa')
                    ->label('Hasil Diagnosa')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Normal' => 'success', // Hijau
                        'Ringan' => 'info',
                        'Sedang' => 'warning',
                        'Berat' => 'danger', // Merah
                        'Sangat Berat' => 'danger',
                        default => 'gray',
                    }),

                // Menampilkan Persentase
                TextColumn::make('persentase_cf')
                    ->label('Tingkat Keyakinan')
                    ->numeric(2) // 2 angka di belakang koma
                    ->suffix('%')
                    ->sortable(),
            ])
            ->filters([
                // Filter bisa ditambahkan nanti jika butuh
            ])
            ->actions([
                // HANYA VIEW, tidak ada Edit
                // ViewAction::make(), 
                // DeleteAction::make(), // Aktifkan ini jika admin boleh menghapus history
            ])
            ->bulkActions([
                // Kosongkan atau biarkan default delete bulk jika perlu
            ]
        );
    }
}