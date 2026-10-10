<?php

namespace App\Filament\Resources\Branches\Pages;

use App\Filament\Forms\Components\MediaPicker;
use App\Filament\Resources\Branches\BranchResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Icons\Heroicon;

class CreateBranch extends CreateRecord
{
    protected static string $resource = BranchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('volver')
                ->label('Volver a Sucursales')
                ->icon(Heroicon::OutlinedArrowLeft)
                ->color('gray')
                ->url(BranchResource::getUrl('index')),
        ];
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return MediaPicker::mutateData($data, 'imagen');
    }
}
