<?php

namespace App\Filament\Resources\InklusiEksklusis\Pages;

use App\Filament\Resources\InklusiEksklusis\InklusiEksklusiResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewInklusiEksklusi extends ViewRecord
{
    protected static string $resource = InklusiEksklusiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
