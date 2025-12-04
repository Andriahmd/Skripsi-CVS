<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\Builder; // <--- JANGAN LUPA TAMBAHKAN INI DI ATAS

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            // --- TAMBAHAN DISINI ---
            ->modifyQueryUsing(function (Builder $query) {
                // Opsi 1: Sembunyikan berdasarkan Email Admin
                return $query->where('email', '!=', 'admin@gmail.com');
                
                
            })
            // -----------------------
            
            ->columns([
                // 1. Menampilkan Nama
                TextColumn::make('name')
                    ->label('Nama Lengkap')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                // 2. Menampilkan Email
                TextColumn::make('email')
                    ->label('Email Address')
                    ->icon('heroicon-m-envelope')
                    ->searchable()
                    ->copyable(),

                // ... (kode kolom lainnya tetap sama) ...
                TextColumn::make('umur')
                    ->label('Umur')
                    ->numeric()
                    ->suffix(' Tahun')
                    ->sortable()
                    ->default('-'),

                TextColumn::make('created_at')
                    ->label('Bergabung Sejak')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->filters([
                //
            ]);
            
    }
}