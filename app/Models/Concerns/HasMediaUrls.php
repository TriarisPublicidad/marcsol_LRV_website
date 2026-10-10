<?php

namespace App\Models\Concerns;

use Illuminate\Support\Facades\Storage;

trait HasMediaUrls
{
    /**
     * Resuelve de forma uniforme una ruta de archivo local o una URL externa.
     */
    public function resolveMediaUrl(?string $path): ?string
    {
        if (empty($path)) {
            return null;
        }

        // Si ya es una URL absoluta externa (http:// o https://)
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        // Si es una ruta relativa que empieza por /storage/
        if (str_starts_with($path, '/storage/')) {
            return asset($path);
        }

        // Si es una ruta relativa en el disco público (ej. media/sucursales/foto.webp)
        return Storage::disk('public')->url($path);
    }
}
