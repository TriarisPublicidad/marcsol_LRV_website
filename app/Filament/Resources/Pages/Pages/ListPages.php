<?php

namespace App\Filament\Resources\Pages\Pages;

use App\Filament\Resources\Pages\PageResource;
use App\Models\Page;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;

class ListPages extends ListRecords
{
    protected static string $resource = PageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Crear Nueva Página')
                ->icon(Heroicon::OutlinedPlusCircle),
        ];
    }

    public function getTabs(): array
    {
        return [
            'todas' => Tab::make('Todas las Páginas')
                ->icon(Heroicon::OutlinedDocumentDuplicate)
                ->badge(fn () => Page::count()),

            'publicadas' => Tab::make('Páginas Activas')
                ->icon(Heroicon::OutlinedCheckCircle)
                ->badge(fn () => Page::where('status', true)->count())
                ->badgeColor('success')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', true)),

            'borradores' => Tab::make('Borradores')
                ->icon(Heroicon::OutlinedClock)
                ->badge(fn () => Page::where('status', false)->count())
                ->badgeColor('gray')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', false)),

            'papelera' => Tab::make('Papelera de Reciclaje')
                ->icon(Heroicon::OutlinedTrash)
                ->badge(fn () => Page::onlyTrashed()->count())
                ->badgeColor('danger')
                ->modifyQueryUsing(fn (Builder $query) => $query->onlyTrashed()),
        ];
    }
}
