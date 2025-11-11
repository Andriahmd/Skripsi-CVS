<?php

namespace App\Filament\Resources\Jawabans;

use App\Filament\Resources\Jawabans\Pages\CreateJawaban;
use App\Filament\Resources\Jawabans\Pages\EditJawaban;
use App\Filament\Resources\Jawabans\Pages\ListJawabans;
use App\Filament\Resources\Jawabans\Pages\ViewJawaban;
use App\Filament\Resources\Jawabans\Schemas\JawabanForm;
use App\Filament\Resources\Jawabans\Schemas\JawabanInfolist;
use App\Filament\Resources\Jawabans\Tables\JawabansTable;
use App\Models\Jawaban;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class JawabanResource extends Resource
{
    protected static ?string $model = Jawaban::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static ?string $navigationLabel = 'Jawaban';
    protected static ?string $pluralLabel = 'Jawaban';

    public static function form(Schema $schema): Schema
    {
        return JawabanForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return JawabanInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return JawabansTable::configure($table);
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
            'index' => ListJawabans::route('/'),
            // 'create' => CreateJawaban::route(path: '/create'),
            'view' => ViewJawaban::route('/{record}'),
            'edit' => EditJawaban::route('/{record}/edit'),
        ];
    }
}
