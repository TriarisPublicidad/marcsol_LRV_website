<?php

namespace App\Filament\Resources\Redirect301s\Pages;

use App\Filament\Resources\Redirect301s\Redirect301Resource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Icons\Heroicon;

class CreateRedirect301 extends CreateRecord
{
    protected static string $resource = Redirect301Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('volver')
                ->label('Volver a Redirecciones')
                ->icon(Heroicon::OutlinedArrowLeft)
                ->color('gray')
                ->url(Redirect301Resource::getUrl('index')),
        ];
    }
}
