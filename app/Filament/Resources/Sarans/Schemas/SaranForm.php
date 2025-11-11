<?php

namespace App\Filament\Resources\Sarans\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class SaranForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('id_periksa')
                    ->required()
                    ->numeric(),
                Textarea::make('isi_saran')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
