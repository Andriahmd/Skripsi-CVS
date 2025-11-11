<?php

namespace App\Filament\Resources\Pemeriksaans\Pages;

use App\Filament\Resources\Pemeriksaans\PemeriksaanResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPemeriksaan extends ViewRecord
{
    protected static string $resource = PemeriksaanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
