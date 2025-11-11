<?php

namespace App\Filament\Resources\Sarans\Pages;

use App\Filament\Resources\Sarans\SaranResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditSaran extends EditRecord
{
    protected static string $resource = SaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
