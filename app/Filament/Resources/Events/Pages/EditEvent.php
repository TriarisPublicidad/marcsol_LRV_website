<?php

namespace App\Filament\Resources\Events\Pages;

use App\Filament\Forms\Components\MediaPicker;
use App\Filament\Resources\Events\EventResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;

class EditEvent extends EditRecord
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
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return MediaPicker::mutateData($data, 'imagen');
    }
}
