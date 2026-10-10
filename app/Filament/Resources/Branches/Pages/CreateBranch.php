<?php

namespace App\Filament\Resources\Branches\Pages;

use App\Filament\Forms\Components\MediaPicker;
use App\Filament\Resources\Branches\BranchResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBranch extends CreateRecord
{
    protected static string $resource = BranchResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return MediaPicker::mutateData($data, 'imagen');
    }
}
