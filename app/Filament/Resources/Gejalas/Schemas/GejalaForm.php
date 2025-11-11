<?php

namespace App\Filament\Resources\Gejalas\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class GejalaForm
{
    public static function configure(Schema $schema): Schema
    {
       return $schema->schema([
            TextInput::make('kode_gejala')
                ->required()
                ->maxLength(255)
                ->unique(),
            Textarea::make('deskripsi')
                ->required()
                ->rows(3),
            Select::make('bobot')
                ->label('Bobot')
                ->required()
                ->options([
                    '0.0' => '0.0',
                    '0.4' => '0.4',
                    '0.6' => '0.6',
                    '0.8' => '0.8',
                ])
                ->default('0.0')
                ->searchable(false),
        ]);
    }
}
