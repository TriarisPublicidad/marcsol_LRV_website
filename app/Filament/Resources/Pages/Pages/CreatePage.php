<?php

namespace App\Filament\Resources\Pages\Pages;

use App\Filament\Forms\Components\MediaPicker;
use App\Filament\Resources\Pages\PageResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Icons\Heroicon;

class CreatePage extends CreateRecord
{
    protected static string $resource = PageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('volver')
                ->label('Volver a Páginas')
                ->icon(Heroicon::OutlinedArrowLeft)
                ->color('gray')
                ->url(PageResource::getUrl('index')),
        ];
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return MediaPicker::mutateData($data, 'og_image');
    }
}
