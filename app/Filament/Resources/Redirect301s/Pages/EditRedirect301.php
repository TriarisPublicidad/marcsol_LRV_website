<?php

namespace App\Filament\Resources\Redirect301s\Pages;

use App\Filament\Resources\Redirect301s\Redirect301Resource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;

class EditRedirect301 extends EditRecord
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
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
