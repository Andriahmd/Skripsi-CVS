<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\Pemeriksaan;

class LatestPemeriksaan extends BaseWidget
{
    protected static ?int $sort = 2;
    
    protected int | string | array $columnSpan = 'full';
    
    protected static ?string $heading = 'Pemeriksaan Terbaru';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Pemeriksaan::query()
                    ->with('user')
                    ->whereNotNull('hasil_diagnosa')
                    ->latest('tanggal')
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama Pasien')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-m-user'),
                
                Tables\Columns\TextColumn::make('user.umur')
                    ->label('Usia')
                    ->suffix(' tahun')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('tanggal')
                    ->label('Tanggal Pemeriksaan')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->icon('heroicon-m-calendar'),
                
                Tables\Columns\TextColumn::make('hasil_diagnosa')
                    ->label('Hasil Diagnosis')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Berat' => 'danger',
                        'Sedang' => 'warning',
                        'Ringan' => 'info',
                        'Tidak Mengalami' => 'success',
                        default => 'gray',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'Berat' => 'heroicon-m-exclamation-triangle',
                        'Sedang' => 'heroicon-m-exclamation-circle',
                        'Ringan' => 'heroicon-m-information-circle',
                        'Tidak Mengalami' => 'heroicon-m-check-circle',
                        default => 'heroicon-m-question-mark-circle',
                    })
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('persentase_cf')
                    ->label('Persentase CF')
                    ->formatStateUsing(fn ($state) => number_format($state, 2) . '%')
                    ->sortable()
                    ->color(fn ($state): string => match (true) {
                        $state >= 75 => 'danger',
                        $state >= 50 => 'warning',
                        $state >= 25 => 'info',
                        default => 'success',
                    }),
            ])
            ->defaultSort('tanggal', 'desc');
    }
}