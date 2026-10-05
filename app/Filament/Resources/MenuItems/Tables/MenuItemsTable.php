<?php

namespace App\Filament\Resources\MenuItems\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class MenuItemsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('titulo')
                    ->label('Texto Enlace')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('url')
                    ->label('URL')
                    ->searchable()
                    ->copyable(),
                TextColumn::make('ubicacion')
                    ->label('Ubicación')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'header' => 'primary',
                        'footer' => 'warning',
                        default => 'gray',
                    })
                    ->sortable(),
                TextColumn::make('parent.titulo')
                    ->label('Menú Padre')
                    ->placeholder('Nivel Superior'),
                TextColumn::make('orden')
                    ->label('Orden')
                    ->sortable(),
                IconColumn::make('status')
                    ->label('Activo')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('ubicacion')
                    ->options([
                        'header' => 'Header',
                        'footer' => 'Footer',
                    ]),
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('orden', 'asc');
    }
}
