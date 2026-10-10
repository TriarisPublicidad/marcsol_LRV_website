<?php

namespace App\Filament\Resources\MediaAssets\Pages;

use App\Filament\Resources\MediaAssets\MediaAssetResource;
use App\Services\MediaSecurityService;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Storage;

class EditMediaAsset extends EditRecord
{
    protected static string $resource = MediaAssetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('volver')
                ->label('Volver a Medios')
                ->icon(Heroicon::OutlinedArrowLeft)
                ->color('gray')
                ->url(MediaAssetResource::getUrl('index')),

            Action::make('ver')
                ->label('Ver')
                ->icon(Heroicon::OutlinedArrowTopRightOnSquare)
                ->color('gray')
                ->url(fn (): string => $this->getRecord()->url)
                ->openUrlInNewTab(),

            RestoreAction::make()
                ->label('Restaurar')
                ->icon(Heroicon::OutlinedArrowUturnLeft)
                ->color('success')
                ->visible(fn (): bool => $this->getRecord()->trashed()),

            DeleteAction::make()
                ->label('Mover a Papelera')
                ->icon(Heroicon::OutlinedTrash)
                ->hidden(fn (): bool => $this->getRecord()->trashed()),

            ForceDeleteAction::make()
                ->label('Eliminar Definitivo')
                ->icon(Heroicon::OutlinedTrash)
                ->color('danger')
                ->visible(fn (): bool => $this->getRecord()->trashed()),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $disk = $data['disco'] ?? 'public';

        if (! empty($data['archivo'])) {
            $path = $data['archivo'];
            $storage = Storage::disk($disk);

            if ($storage->exists($path)) {
                $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                $mime = $storage->mimeType($path);

                MediaSecurityService::validateFile(basename($path), $mime);

                if ($ext === 'svg') {
                    MediaSecurityService::sanitizeSvg($path, $disk);
                }

                $data['tamano_bytes'] = $storage->size($path);
                $data['mime_type'] = $mime;
                $data['tipo'] = MediaSecurityService::detectMediaType($ext);

                if ($data['tipo'] === 'imagen' && $ext !== 'svg') {
                    $dimensions = MediaSecurityService::getImageDimensions($path, $disk);
                    $data['ancho'] = $dimensions['ancho'];
                    $data['alto'] = $dimensions['alto'];
                }
            }
        }

        return $data;
    }
}

