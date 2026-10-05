<?php

namespace App\Filament\Resources\Redirect301s\Pages;

use App\Filament\Resources\Redirect301s\Redirect301Resource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRedirect301s extends ListRecords
{
    protected static string $resource = Redirect301Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Nueva Redirección')
                ->icon(\Filament\Support\Icons\Heroicon::OutlinedPlusCircle),

            \Filament\Actions\Action::make('limpiar_cache')
                ->label('Regenerar Caché 301')
                ->icon(\Filament\Support\Icons\Heroicon::OutlinedArrowPath)
                ->color('gray')
                ->tooltip('Regenera el mapa en memoria de redirecciones activas')
                ->action(function () {
                    \App\Models\Redirect301::clearCache();
                    $total = count(\App\Models\Redirect301::getCachedMap());
                    \Filament\Notifications\Notification::make()
                        ->title('Caché de Redirecciones Actualizado')
                        ->body("Se han cargado {$total} redirecciones activas en memoria para acceso ultrarrápido.")
                        ->success()
                        ->send();
                }),
        ];
    }
}
