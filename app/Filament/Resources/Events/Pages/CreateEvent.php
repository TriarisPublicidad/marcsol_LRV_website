<?php

namespace App\Filament\Resources\Events\Pages;

use App\Filament\Forms\Components\MediaPicker;
use App\Filament\Resources\Events\EventResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEvent extends CreateRecord
{
    protected static string $resource = EventResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return MediaPicker::mutateData($data, 'imagen');
    }
}
