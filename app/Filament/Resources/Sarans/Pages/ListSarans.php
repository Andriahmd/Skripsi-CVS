<?php

namespace App\Filament\Resources\Sarans\Pages;

use App\Filament\Resources\Sarans\SaranResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSarans extends ListRecords
{
    protected static string $resource = SaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
