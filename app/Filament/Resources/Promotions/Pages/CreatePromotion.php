<?php

namespace App\Filament\Resources\Promotions\Pages;

use App\Filament\Forms\Components\MediaPicker;
use App\Filament\Resources\Promotions\PromotionResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePromotion extends CreateRecord
{
    protected static string $resource = PromotionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data = MediaPicker::mutateData($data, 'imagen');
        $data = MediaPicker::mutateData($data, 'pdf_volante');

        return $data;
    }
}
