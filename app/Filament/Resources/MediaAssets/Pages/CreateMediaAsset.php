<?php

namespace App\Filament\Resources\MediaAssets\Pages;

use App\Filament\Resources\MediaAssets\MediaAssetResource;
use App\Services\MediaSecurityService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;

class CreateMediaAsset extends CreateRecord
{
    protected static string $resource = MediaAssetResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        $disk = $data['disco'] ?? 'public';

        if (! empty($data['archivo'])) {
            $path = $data['archivo'];
            $storage = Storage::disk($disk);

            if ($storage->exists($path)) {
                $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                $mime = $storage->mimeType($path);

                // Validación estricta de seguridad
                MediaSecurityService::validateFile(basename($path), $mime);

                // Sanitización si es archivo vectorial SVG
                if ($ext === 'svg') {
                    MediaSecurityService::sanitizeSvg($path, $disk);
                }

                $data['tamano_bytes'] = $storage->size($path);
                $data['mime_type'] = $mime;
                $data['tipo'] = MediaSecurityService::detectMediaType($ext);

                // Dimensiones si es imagen
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

