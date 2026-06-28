<?php

namespace App\Filament\Resources\Accommodations;

use App\Filament\Resources\Accommodations\Pages\CreateAccommodation;
use App\Filament\Resources\Accommodations\Pages\EditAccommodation;
use App\Filament\Resources\Accommodations\Pages\ListAccommodations;
use App\Filament\Resources\Accommodations\Schemas\AccommodationForm;
use App\Filament\Resources\Accommodations\Tables\AccommodationsTable;
use App\Models\Accommodation;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AccommodationResource extends Resource
{
    protected static ?string $model = Accommodation::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHomeModern;

    protected static string|\UnitEnum|null $navigationGroup = 'Content';

    protected static ?int $navigationSort = 40;

    public static function form(Schema $schema): Schema
    {
        return AccommodationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AccommodationsTable::configure($table);
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
            'index' => ListAccommodations::route('/'),
            'create' => CreateAccommodation::route('/create'),
            'edit' => EditAccommodation::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
