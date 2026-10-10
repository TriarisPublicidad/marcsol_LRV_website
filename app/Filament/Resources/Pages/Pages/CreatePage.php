<?php

namespace App\Filament\Resources\Pages\Pages;

use App\Filament\Forms\Components\MediaPicker;
use App\Filament\Resources\Pages\PageResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePage extends CreateRecord
{
    protected static string $resource = PageResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return MediaPicker::mutateData($data, 'og_image');
    }
}
