<?php

namespace App\Filament\Resources\Redirect301s\Pages;

use App\Filament\Resources\Redirect301s\Redirect301Resource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditRedirect301 extends EditRecord
{
    protected static string $resource = Redirect301Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
