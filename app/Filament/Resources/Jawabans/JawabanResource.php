<?php

namespace App\Filament\Resources\Jawabans;

use App\Filament\Resources\Jawabans\Pages\ListJawabans;
use App\Filament\Resources\Jawabans\Pages\ViewJawaban;
use App\Filament\Resources\Jawabans\Schemas\JawabanInfolist; // Import file Infolist
use App\Filament\Resources\Jawabans\Tables\JawabansTable;    // Import file Table
use App\Models\Jawaban;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Schemas\Schema; // Wajib import Schema
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class JawabanResource extends Resource
{
    protected static ?string $model = Jawaban::class;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Jawaban';

    // Bagian ini yang mengatur TAMPILAN POP-UP/DETAIL
    public static function infolist(Schema $schema): Schema
    {
        // Pastikan ini memanggil class JawabanInfolist yang isinya TextEntry & RepeatableEntry
        return JawabanInfolist::configure($schema);
    }

    // Bagian ini yang mengatur TABEL DEPAN
    public static function table(Table $table): Table
    {
        // Pastikan ini memanggil class JawabansTable yang isinya TextColumn
        return JawabansTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListJawabans::route('/'),
            'view' => ViewJawaban::route('/{record}'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        // Query grouping agar tidak duplikat
        return parent::getEloquentQuery()
            ->select('jawaban.*')
            ->whereIn('jawaban.id_jawaban', function ($query) {
                $query->select(DB::raw('MIN(id_jawaban)'))
                    ->from('jawaban')
                    ->groupBy('id_pemeriksaan');
            })
            ->with(['pemeriksaan.user'])
            ->orderByDesc('id_pemeriksaan');
    }
}