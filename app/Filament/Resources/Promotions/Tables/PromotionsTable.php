<?php

namespace App\Filament\Resources\Promotions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class PromotionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('imagen')
                    ->label('Banner')
                    ->disk('public')
                    ->circular(),
                TextColumn::make('titulo')
                    ->label('Promoción')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->limit(35),
                TextColumn::make('category.nombre')
                    ->label('Categoría')
                    ->badge()
                    ->color('info')
                    ->sortable(),
                TextColumn::make('branch.nombre')
                    ->label('Sucursal')
                    ->placeholder('Todas')
                    ->sortable(),
                IconColumn::make('es_promocion_del_dia')
                    ->label('Promo del Día')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('fecha_inicio')
                    ->label('Desde')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('fecha_fin')
                    ->label('Hasta')
                    ->date('d/m/Y')
                    ->sortable(),
                IconColumn::make('status')
                    ->label('Activo')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('category_id')
                    ->relationship('category', 'nombre')
                    ->label('Categoría'),
                SelectFilter::make('branch_id')
                    ->relationship('branch', 'nombre')
                    ->label('Sucursal'),
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
