<?php

namespace App\Filament\Resources\InklusiEksklusis\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InklusiEksklusisTable
{
    public static function configure(Table $table): Table
    {
       return $table
            ->columns([
                TextColumn::make('id_inklusi_eksklusi')
                    ->label('ID Inklusi & Eksklusi')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('memenuhi_inklusi')
                    ->label('Kondisi Inklusi')
                    ->wrap()
                    ->sortable()
                    ->searchable()
                    ->limit(50), // Batasi karakter yang ditampilkan

                TextColumn::make('ada_eksklusi')
                    ->label('Kondisi Eksklusi')
                    ->wrap()
                    ->sortable()
                    ->searchable()
                    ->limit(50),

                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Diperbarui Pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Tambah filter kalau perlu
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}