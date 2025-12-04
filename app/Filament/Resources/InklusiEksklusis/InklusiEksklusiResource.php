<?php

namespace App\Filament\Resources\InklusiEksklusis;

use App\Filament\Resources\InklusiEksklusis\Pages\CreateInklusiEksklusi;
use App\Filament\Resources\InklusiEksklusis\Pages\EditInklusiEksklusi;
use App\Filament\Resources\InklusiEksklusis\Pages\ListInklusiEksklusis;
use App\Filament\Resources\InklusiEksklusis\Pages\ViewInklusiEksklusi;
use App\Filament\Resources\InklusiEksklusis\Schemas\InklusiEksklusiForm;
use App\Filament\Resources\InklusiEksklusis\Schemas\InklusiEksklusiInfolist;
use App\Filament\Resources\InklusiEksklusis\Tables\InklusiEksklusisTable;
use App\Models\InklusiEksklusi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class InklusiEksklusiResource extends Resource
{
    protected static ?string $model = InklusiEksklusi::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
 protected static ?string $navigationLabel = 'Inklusi & Eksklusi';
    protected static ?string $pluralLabel = 'Inklusi & Eksklusi';
    protected static ?string $recordTitleAttribute = 'Pemeriksaan';

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

    // public static function getRecordTitle(Model $record): string
    // {
      
    //     return $record->pemeriksaan->user->name ?? 'Screening #' . $record->id_inklusi_eksklusi;
    // }

    public static function getPages(): array
    {
        return [
            'index' => ListInklusiEksklusis::route('/'),
            'create' => CreateInklusiEksklusi::route('/create'),
            'view' => ViewInklusiEksklusi::route('/{record}'),
            'edit' => EditInklusiEksklusi::route('/{record}/edit'),
        ];
    }
}
