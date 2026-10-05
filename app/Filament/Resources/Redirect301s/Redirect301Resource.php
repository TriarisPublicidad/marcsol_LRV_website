<?php

namespace App\Filament\Resources\Redirect301s;

use App\Filament\Resources\Redirect301s\Pages\CreateRedirect301;
use App\Filament\Resources\Redirect301s\Pages\EditRedirect301;
use App\Filament\Resources\Redirect301s\Pages\ListRedirect301s;
use App\Filament\Resources\Redirect301s\Schemas\Redirect301Form;
use App\Filament\Resources\Redirect301s\Tables\Redirect301sTable;
use App\Models\Redirect301;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class Redirect301Resource extends Resource
{
    protected static ?string $model = Redirect301::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowPath;

    protected static UnitEnum|string|null $navigationGroup = 'SEO & Sistema';

    protected static ?string $modelLabel = 'Redirección 301';

    protected static ?string $pluralModelLabel = 'Redirecciones 301';

    protected static ?string $navigationLabel = 'Redirecciones 301';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return Redirect301Form::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return Redirect301sTable::configure($table);
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
            'index' => ListRedirect301s::route('/'),
            'create' => CreateRedirect301::route('/create'),
            'edit' => EditRedirect301::route('/{record}/edit'),
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
