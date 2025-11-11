<?php

namespace App\Filament\Resources\Sarans;

use App\Filament\Resources\Sarans\Pages\CreateSaran;
use App\Filament\Resources\Sarans\Pages\EditSaran;
use App\Filament\Resources\Sarans\Pages\ListSarans;
use App\Filament\Resources\Sarans\Pages\ViewSaran;
use App\Filament\Resources\Sarans\Schemas\SaranForm;
use App\Filament\Resources\Sarans\Schemas\SaranInfolist;
use App\Filament\Resources\Sarans\Tables\SaransTable;
use App\Models\Saran;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SaranResource extends Resource
{
    protected static ?string $model = Saran::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static ?string $navigationLabel = 'Saran';
    protected static ?string $pluralLabel = 'Saran';
    public static function form(Schema $schema): Schema
    {
        return SaranForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SaranInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SaransTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSarans::route('/'),
            'create' => CreateSaran::route('/create'),
            'view' => ViewSaran::route('/{record}'),
            'edit' => EditSaran::route('/{record}/edit'),
        ];
    }
}
