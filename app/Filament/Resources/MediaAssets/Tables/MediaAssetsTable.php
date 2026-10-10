<?php

namespace App\Filament\Resources\MediaAssets\Tables;

use App\Models\MediaAsset;
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
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class MediaAssetsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('archivo')
                    ->label('Vista')
                    ->state(fn (MediaAsset $record) => $record->tipo === 'imagen' ? $record->url : null)
                    ->square()
                    ->size(50)
                    ->defaultImageUrl(asset('images/media-placeholder.svg')),

                TextColumn::make('titulo')
                    ->label('Nombre del Recurso')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn (MediaAsset $record): string => $record->archivo),

                TextColumn::make('carpeta')
                    ->label('Carpeta')
                    ->badge()
                    ->color('gray')
                    ->sortable(),

                TextColumn::make('tipo')
                    ->label('Tipo')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'imagen' => 'success',
                        'pdf' => 'danger',
                        'video' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'imagen' => 'Imagen',
                        'pdf' => 'PDF',
                        'video' => 'Video',
                        default => 'Documento',
                    })
                    ->sortable(),

                TextColumn::make('dimensiones_texto')
                    ->label('Dimensiones')
                    ->placeholder('—')
                    ->toggleable(),

                TextColumn::make('tamano_formateado')
                    ->label('Peso')
                    ->sortable(query: fn ($query, $direction) => $query->orderBy('tamano_bytes', $direction)),

                TextColumn::make('url')
                    ->label('URL')
                    ->limit(20)
                    ->copyable()
                    ->copyMessage('URL copiada al portapapeles')
                    ->copyMessageDuration(2000)
                    ->tooltip('Clic para copiar URL')
                    ->color('primary'),

                TextColumn::make('created_at')
                    ->label('Subido')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('carpeta')
                    ->label('Filtrar por Carpeta')
                    ->options(fn () => MediaAsset::distinct()->pluck('carpeta', 'carpeta')->toArray()),

                SelectFilter::make('tipo')
                    ->label('Filtrar por Tipo')
                    ->options([
                        'imagen' => 'Imágenes',
                        'pdf' => 'Documentos PDF',
                        'video' => 'Videos',
                        'documento' => 'Otros',
                    ]),

                TrashedFilter::make()->label('Filtrar por Papelera'),
            ])
            ->recordActions([
                Action::make('ver')
                    ->label('Ver')
                    ->icon(Heroicon::OutlinedArrowTopRightOnSquare)
                    ->color('gray')
                    ->tooltip('Abrir recurso en nueva pestaña')
                    ->url(fn (MediaAsset $record): string => $record->url)
                    ->openUrlInNewTab(),

                EditAction::make()
                    ->label('Editar')
                    ->icon(Heroicon::OutlinedPencilSquare)
                    ->hidden(fn (MediaAsset $record) => $record->trashed()),

                RestoreAction::make()
                    ->label('Restaurar')
                    ->icon(Heroicon::OutlinedArrowUturnLeft)
                    ->color('success')
                    ->visible(fn (MediaAsset $record) => $record->trashed()),

                DeleteAction::make()
                    ->label('Papelera')
                    ->icon(Heroicon::OutlinedTrash)
                    ->tooltip('Mover a la papelera')
                    ->hidden(fn (MediaAsset $record) => $record->trashed()),

                ForceDeleteAction::make()
                    ->label('Eliminar Definitivo')
                    ->icon(Heroicon::OutlinedTrash)
                    ->color('danger')
                    ->visible(fn (MediaAsset $record) => $record->trashed()),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->label('Mover a Papelera'),
                    RestoreBulkAction::make()->label('Restaurar Seleccionados'),
                    ForceDeleteBulkAction::make()->label('Eliminar Permanentemente'),
                ]),
            ]);
    }
}

