<?php

namespace App\Filament\Resources\Sarans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;

class SaransTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id_saran')
                    ->label('ID')
                    ->numeric()
                    ->sortable(),
                
                BadgeColumn::make('kategori')
                    ->label('Kategori')
                    ->colors([
                        'success' => 'Tidak Mengalami',
                        'warning' => 'Ringan',
                        'danger' => fn ($state) => in_array($state, ['Sedang', 'Berat']),
                    ])
                    ->icons([
                        'heroicon-o-check-circle' => 'Tidak Mengalami',
                        'heroicon-o-exclamation-circle' => 'Ringan',
                        'heroicon-o-exclamation-triangle' => 'Sedang',
                        'heroicon-o-x-circle' => 'Berat',
                    ])
                    ->sortable()
                    ->searchable(),
                
                TextColumn::make('persentase_min')
                    ->label('Min (%)')
                    ->numeric(decimalPlaces: 2)
                    ->sortable()
                    ->suffix('%'),
                
                TextColumn::make('persentase_max')
                    ->label('Max (%)')
                    ->numeric(decimalPlaces: 2)
                    ->sortable()
                    ->suffix('%'),
                
                TextColumn::make('range_persentase')
                    ->label('Range Persentase')
                    ->getStateUsing(fn ($record) => $record->persentase_min . '% - ' . $record->persentase_max . '%')
                    ->badge()
                    ->color('info'),
                
                TextColumn::make('isi_saran')
                    ->label('Isi Saran')
                    ->limit(50)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 50) {
                            return null;
                        }
                        return $state;
                    })
                    ->searchable()
                    ->wrap(),
                
                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                TextColumn::make('updated_at')
                    ->label('Diperbarui Pada')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('kategori')
                    ->label('Filter Kategori')
                    ->options([
                        'Tidak Mengalami' => 'Tidak Mengalami',
                        'Ringan' => 'Ringan',
                        'Sedang' => 'Sedang',
                        'Berat' => 'Berat',
                    ])
                    ->placeholder('Semua Kategori'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('persentase_min', 'asc');
    }
}