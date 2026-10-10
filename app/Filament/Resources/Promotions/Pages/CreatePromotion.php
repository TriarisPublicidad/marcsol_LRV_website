<?php

namespace App\Filament\Resources\Promotions\Pages;

use App\Filament\Forms\Components\MediaPicker;
use App\Filament\Resources\Promotions\PromotionResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Icons\Heroicon;

class CreatePromotion extends CreateRecord
{
    protected static string $resource = PromotionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('volver')
                ->label('Volver a Promociones')
                ->icon(Heroicon::OutlinedArrowLeft)
                ->color('gray')
                ->url(PromotionResource::getUrl('index')),
        ];
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data = MediaPicker::mutateData($data, 'imagen');
        $data = MediaPicker::mutateData($data, 'pdf_volante');

        return $data;
    }
}
