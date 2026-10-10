<?php

namespace App\Filament\Resources\MenuItems\Pages;

use App\Filament\Resources\MenuItems\MenuItemResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Icons\Heroicon;

class CreateMenuItem extends CreateRecord
{
    protected static string $resource = MenuItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('volver')
                ->label('Volver a Menús')
                ->icon(Heroicon::OutlinedArrowLeft)
                ->color('gray')
                ->url(MenuItemResource::getUrl('index')),
        ];
    }
}
