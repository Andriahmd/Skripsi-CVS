<?php

namespace App\Filament\Resources\Sarans\Pages;

use App\Filament\Resources\Sarans\SaranResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewSaran extends ViewRecord
{
    protected static string $resource = SaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
