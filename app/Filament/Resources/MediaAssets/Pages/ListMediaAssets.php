<?php

namespace App\Filament\Resources\MediaAssets\Pages;

use App\Filament\Resources\MediaAssets\MediaAssetResource;
use App\Models\MediaAsset;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;

class ListMediaAssets extends ListRecords
{
    protected static string $resource = MediaAssetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Subir Archivo')
                ->icon(Heroicon::OutlinedArrowUpTray),
        ];
    }

    public function getTabs(): array
    {
        return [
            'todos' => Tab::make('Todos')
                ->icon(Heroicon::OutlinedFolder)
                ->badge(fn () => MediaAsset::count()),

            'imagenes' => Tab::make('Imágenes')
                ->icon(Heroicon::OutlinedPhoto)
                ->badge(fn () => MediaAsset::where('tipo', 'imagen')->count())
                ->badgeColor('success')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('tipo', 'imagen')),

            'pdfs' => Tab::make('Documentos PDF')
                ->icon(Heroicon::OutlinedDocumentText)
                ->badge(fn () => MediaAsset::where('tipo', 'pdf')->count())
                ->badgeColor('danger')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('tipo', 'pdf')),

            'videos' => Tab::make('Videos')
                ->icon(Heroicon::OutlinedFilm)
                ->badge(fn () => MediaAsset::where('tipo', 'video')->count())
                ->badgeColor('warning')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('tipo', 'video')),

            'papelera' => Tab::make('Papelera')
                ->icon(Heroicon::OutlinedTrash)
                ->badge(fn () => MediaAsset::onlyTrashed()->count())
                ->badgeColor('gray')
                ->modifyQueryUsing(fn (Builder $query) => $query->onlyTrashed()),
        ];
    }
}

