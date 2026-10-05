<?php

namespace App\Filament\Resources\Pages\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class PagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('titulo')
                    ->label('Título de Página')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('slug')
                    ->label('Ruta Web')
                    ->badge()
                    ->color(fn ($state) => $state === 'inicio' ? 'warning' : 'gray')
                    ->formatStateUsing(fn ($state) => $state === 'inicio' ? '/ (Portada Principal)' : "/{$state}"),
                TextColumn::make('contenido_json_bloques')
                    ->label('Bloques Modulares')
                    ->badge()
                    ->color('info')
                    ->formatStateUsing(fn ($state) => is_array($state) ? count($state) . ' bloques' : '0 bloques'),
                IconColumn::make('status')
                    ->label('Publicada')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Fecha Creación')
                    ->dateTime('d/m/Y')
                    ->sortable(),
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
