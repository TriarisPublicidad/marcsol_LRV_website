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
            CreateAction::make(),
        ];
    }
}
