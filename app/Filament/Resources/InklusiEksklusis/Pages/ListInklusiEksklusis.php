<?php

namespace App\Filament\Resources\InklusiEksklusis\Pages;

use App\Filament\Resources\InklusiEksklusis\InklusiEksklusiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInklusiEksklusis extends ListRecords
{
    protected static string $resource = InklusiEksklusiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
