<?php

namespace App\Filament\Resources\Promotions\Pages;

use App\Filament\Forms\Components\MediaPicker;
use App\Filament\Resources\Promotions\PromotionResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;

class EditPromotion extends EditRecord
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
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data = MediaPicker::mutateData($data, 'imagen');
        $data = MediaPicker::mutateData($data, 'pdf_volante');

        return $data;
    }
}
