<?php

namespace App\Filament\Resources\Gejalas\Pages;

use App\Filament\Resources\Gejalas\GejalaResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewGejala extends ViewRecord
{
    protected static string $resource = GejalaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
