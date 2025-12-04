<?php

namespace App\Filament\Resources\InklusiEksklusis\Pages;

use App\Filament\Resources\InklusiEksklusis\InklusiEksklusiResource; 
use Filament\Resources\Pages\ViewRecord;

class ViewInklusiEksklusi extends ViewRecord
{
    protected static string $resource = InklusiEksklusiResource::class;

    // 1. Perbaiki Judul Halaman (Supaya tidak muncul JSON)
    public function getTitle(): string
    {
        return 'Detail Screening: ' . ($this->record->pemeriksaan->user->name ?? 'Pasien');
    }
    protected function getHeaderActions(): array
    {
        return [
            
        ];
    }
}