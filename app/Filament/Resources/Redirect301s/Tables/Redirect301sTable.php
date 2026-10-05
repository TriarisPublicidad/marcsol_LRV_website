<?php

namespace App\Filament\Resources\Redirect301s\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class Redirect301sTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('url_origen')
                    ->label('Ruta de Origen')
                    ->searchable()
                    ->copyable()
                    ->weight('bold'),
                TextColumn::make('url_destino')
                    ->label('Redirige a (Destino)')
                    ->searchable()
                    ->copyable(),
                TextColumn::make('hits')
                    ->label('Impactos')
                    ->badge()
                    ->color('info')
                    ->sortable(),
                IconColumn::make('status')
                    ->label('Activo')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Fecha')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
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
            ]);
    }
}
