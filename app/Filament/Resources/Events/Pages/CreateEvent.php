<?php

namespace App\Filament\Resources\Events\Pages;

use App\Filament\Forms\Components\MediaPicker;
use App\Filament\Resources\Events\EventResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Icons\Heroicon;

class CreateEvent extends CreateRecord
{
    protected static string $resource = EventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('volver')
                ->label('Volver a Eventos')
                ->icon(Heroicon::OutlinedArrowLeft)
                ->color('gray')
                ->url(EventResource::getUrl('index')),
        ];
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return MediaPicker::mutateData($data, 'imagen');
    }
}
