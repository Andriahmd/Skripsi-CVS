<?php

namespace App\Filament\Resources\InklusiEksklusis;

use App\Filament\Resources\InklusiEksklusis\Pages\ListInklusiEksklusis;
use App\Filament\Resources\InklusiEksklusis\Pages\ViewInklusiEksklusi; // Pastikan ini ada
use App\Filament\Resources\InklusiEksklusis\Schemas\InklusiEksklusiForm;
use App\Filament\Resources\InklusiEksklusis\Schemas\InklusiEksklusiInfolist;
use App\Filament\Resources\InklusiEksklusis\Tables\InklusiEksklusisTable;
use App\Models\InklusiEksklusi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class InklusiEksklusiResource extends Resource
{
    protected static ?string $model = InklusiEksklusi::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static ?string $navigationLabel = 'Inklusi & Eksklusi';
    protected static ?string $pluralLabel = 'Inklusi & Eksklusi';
    protected static ?string $recordTitleAttribute = 'Pemeriksaan';
    
    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return InklusiEksklusiForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return InklusiEksklusiInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InklusiEksklusisTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['pemeriksaan.user']) 
            ->latest('id_inklusi_eksklusi'); 
    }

   
    public static function getPages(): array
    {
        return [
            'index' => ListInklusiEksklusis::route('/'),

            'view' => ViewInklusiEksklusi::route('/{record}'), 
        ];
    }
}