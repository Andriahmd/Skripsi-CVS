<?php

namespace App\Filament\Resources\Gejalas\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class GejalaInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('kode_gejala'),
                TextEntry::make('deskripsi')
                    ->columnSpanFull(),
                TextEntry::make('bobot')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
