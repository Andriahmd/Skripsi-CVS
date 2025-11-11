<?php

namespace App\Filament\Resources\Jawabans\Pages;

use App\Filament\Resources\Jawabans\JawabanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListJawabans extends ListRecords
{
    protected static string $resource = JawabanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }
}
