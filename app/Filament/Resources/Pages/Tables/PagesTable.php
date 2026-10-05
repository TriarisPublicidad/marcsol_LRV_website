<?php

namespace App\Filament\Resources\Pages\Tables;

use App\Models\Page;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Support\Icons\Heroicon;
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
                    ->formatStateUsing(fn ($state) => $state === 'inicio' ? '/ (Portada Principal)' : "/{$state}")
                    ->icon(Heroicon::OutlinedArrowTopRightOnSquare)
                    ->url(fn (Page $record): ?string => $record->trashed() ? null : ($record->slug === 'inicio' ? url('/') : url('/' . $record->slug)), shouldOpenInNewTab: true)
                    ->tooltip('Clic para visitar la página web en una nueva pestaña'),
                TextColumn::make('contenido_json_bloques')
                    ->label('Bloques Modulares')
                    ->badge()
                    ->color('info')
                    ->formatStateUsing(fn ($state) => is_array($state) ? count($state) . ' bloques' : '0 bloques'),
                IconColumn::make('status')
                    ->label('Publicada')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Última Actualización')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('Fecha Creación')
                    ->dateTime('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                TrashedFilter::make()->label('Filtrar por Papelera'),
            ])
            ->recordActions([
                Action::make('visitar')
                    ->label('Ver en Web')
                    ->icon(Heroicon::OutlinedArrowTopRightOnSquare)
                    ->color('gray')
                    ->tooltip('Abrir en el sitio web')
                    ->url(fn (Page $record): string => $record->slug === 'inicio' ? url('/') : url('/' . $record->slug))
                    ->openUrlInNewTab()
                    ->hidden(fn (Page $record) => $record->trashed()),

                EditAction::make()
                    ->label('Editar')
                    ->icon(Heroicon::OutlinedPencilSquare)
                    ->hidden(fn (Page $record) => $record->trashed()),

                RestoreAction::make()
                    ->label('Restaurar')
                    ->icon(Heroicon::OutlinedArrowUturnLeft)
                    ->color('success')
                    ->visible(fn (Page $record) => $record->trashed()),

                DeleteAction::make()
                    ->label('Papelera')
                    ->icon(Heroicon::OutlinedTrash)
                    ->tooltip('Mover a la papelera')
                    ->hidden(fn (Page $record) => $record->slug === 'inicio' || $record->trashed()),

                ForceDeleteAction::make()
                    ->label('Eliminar Definitivo')
                    ->icon(Heroicon::OutlinedTrash)
                    ->color('danger')
                    ->hidden(fn (Page $record) => $record->slug === 'inicio')
                    ->visible(fn (Page $record) => $record->trashed()),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->label('Mover a Papelera'),
                    RestoreBulkAction::make()->label('Restaurar Seleccionadas'),
                    ForceDeleteBulkAction::make()->label('Eliminar Permanentemente'),
                ]),
            ]);
    }
}
