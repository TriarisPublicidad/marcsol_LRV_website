<?php

namespace App\Filament\Resources\Categories\Pages;

use App\Filament\Resources\Categories\CategoryResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Icons\Heroicon;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('volver')
                ->label('Volver a Categorías')
                ->icon(Heroicon::OutlinedArrowLeft)
                ->color('gray')
                ->url(CategoryResource::getUrl('index')),
        ];
    }
}
