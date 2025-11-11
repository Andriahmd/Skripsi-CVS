<?php

namespace App\Filament\Resources\InklusiEksklusis\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class InklusiEksklusiInfolist
{
   public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id_inklusi_eksklusi')
                    ->label('ID Inklusi & Eksklusi'),

                TextEntry::make('memenuhi_inklusi')
                    ->label('Kondisi Inklusi')
                    ->wrap(), // biar teks panjang turun ke bawah

                TextEntry::make('ada_eksklusi')
                    ->label('Kondisi Eksklusi')
                    ->wrap(),

                IconEntry::make('memenuhi')
                    ->boolean()
                    ->label('Memenuhi?'),

                TextEntry::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime()
                    ->placeholder('-'),

                TextEntry::make('updated_at')
                    ->label('Diperbarui Pada')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
