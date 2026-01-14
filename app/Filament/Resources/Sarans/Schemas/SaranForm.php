<?php

namespace App\Filament\Resources\Sarans\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class SaranForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('kategori')
                    ->label('Kategori CVS')
                    ->options([
                        'Tidak Mengalami' => 'Tidak Mengalami',
                        'Ringan' => 'Ringan',
                        'Sedang' => 'Sedang',
                        'Berat' => 'Berat',
                    ])
                    ->required()
                    ->native(false)
                    ->searchable()
                    ->placeholder('Pilih kategori tingkat CVS')
                    ->helperText('Pilih kategori tingkat Computer Vision Syndrome')
                    ->columnSpanFull(),
                
                TextInput::make('persentase_min')
                    ->label('Persentase Minimum (%)')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->step(0.01)
                    ->suffix('%')
                    ->placeholder('0.00')
                    ->helperText('Batas bawah range persentase')
                    ->columnStart(1),
                
                TextInput::make('persentase_max')
                    ->label('Persentase Maksimum (%)')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->step(0.01)
                    ->suffix('%')
                    ->placeholder('100.00')
                    ->helperText('Batas atas range persentase')
                    ->rules(['gte:persentase_min']),
                
                Textarea::make('isi_saran')
                    ->label('Saran untuk Pasien')
                    ->required()
                    ->rows(8)
                    ->placeholder('Masukkan saran lengkap dan detail untuk kategori ini...')
                    ->helperText('Saran ini akan ditampilkan pada hasil pemeriksaan pasien')
                    ->columnSpanFull()
                    ->maxLength(5000),
            ])
            ->columns(2);
    }
}