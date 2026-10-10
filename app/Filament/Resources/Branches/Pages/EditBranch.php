<?php

namespace App\Filament\Resources\Branches\Pages;

use App\Filament\Forms\Components\MediaPicker;
use App\Filament\Resources\Branches\BranchResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;

class EditBranch extends EditRecord
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
