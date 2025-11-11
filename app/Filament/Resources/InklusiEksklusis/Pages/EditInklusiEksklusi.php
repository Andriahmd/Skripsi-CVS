<?php

namespace App\Filament\Resources\InklusiEksklusis\Pages;

use App\Filament\Resources\InklusiEksklusis\InklusiEksklusiResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditInklusiEksklusi extends EditRecord
{
    protected static string $resource = InklusiEksklusiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
