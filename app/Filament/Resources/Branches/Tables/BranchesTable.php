<?php

namespace App\Filament\Resources\Branches\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class BranchesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('imagen')
                    ->label('Foto')
                    ->circular()
                    ->disk('public')
                    ->state(function ($record): ?string {
                        if (empty($record->imagen)) {
                            return null;
                        }
                        if (str_starts_with($record->imagen, 'http://') || str_starts_with($record->imagen, 'https://')) {
                            return $record->imagen;
                        }

                        return ltrim(preg_replace('#^/?storage/#', '', $record->imagen), '/');
                    })
                    ->defaultImageUrl(asset('images/media-placeholder.svg')),
                TextColumn::make('nombre')
                    ->label('Sucursal')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('direccion')
                    ->label('Dirección')
                    ->searchable()
                    ->limit(40),
                TextColumn::make('telefono')
                    ->label('Teléfono')
                    ->searchable(),
                TextColumn::make('horarios')
                    ->label('Horarios')
                    ->limit(30),
                IconColumn::make('status')
                    ->label('Estado')
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
