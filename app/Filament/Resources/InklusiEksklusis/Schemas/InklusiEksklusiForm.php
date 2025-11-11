<?php

namespace App\Filament\Resources\InklusiEksklusis\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class InklusiEksklusiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
          ->schema([
                TextInput::make('id_inklusi_eksklusi')
                    ->label('ID Inklusi & Eksklusi')
                    ->required(),

                TextInput::make('memenuhi_inklusi')
                    ->label('Kondisi Inklusi')
                    ->placeholder('Tuliskan kondisi inklusi...')
                    ->required(),

                // TextInput::make('memenuhi')
                //     ->label('Keterangan Inklusi')
                //     ->placeholder('Contoh: Memenuhi sebagian, penuh, atau tidak')
                //     ->required(),

                TextInput::make('ada_eksklusi')
                    ->label('Kondisi Eksklusi')
                    ->placeholder('Tuliskan kondisi eksklusi...')
                    ->required(),
            ]);
    }
}
