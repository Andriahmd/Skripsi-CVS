<?php

namespace App\Filament\Resources\Jawabans\Pages;

use App\Filament\Resources\Jawabans\JawabanResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewJawaban extends ViewRecord
{
    protected static string $resource = JawabanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
