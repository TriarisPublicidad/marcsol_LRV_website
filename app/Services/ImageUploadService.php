<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ImageUploadService
{
    protected ImageManager $manager;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }

    /**
     * Procesa, sanitiza, convierte a WebP y renombra con UUID una imagen.
     */
    public function uploadImage(UploadedFile $file, string $directory = 'uploads', int $quality = 85, ?int $maxWidth = 1920): string
    {
        // Validar tipo MIME permitido
        $allowedMimes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
        if (! in_array($file->getMimeType(), $allowedMimes)) {
            throw new \InvalidArgumentException('Formato de imagen no permitido para subida.');
        }

        // Generar nombre seguro con UUID
        $filename = Str::uuid()->toString() . '.webp';
        $fullPath = trim($directory, '/') . '/' . $filename;

        // Procesar con Intervention Image
        $image = $this->manager->read($file->getRealPath());

        // Redimensionar proporcionalmente si excede el ancho mÃ¡ximo
        if ($maxWidth && $image->width() > $maxWidth) {
            $image->scale(width: $maxWidth);
        }

        // Codificar a WebP
        $encoded = $image->toWebp($quality);

        // Almacenar en disco pÃºblico
        Storage::disk('public')->put($fullPath, (string) $encoded);

        return $fullPath;
    }

    /**
     * Sube y sanitiza archivos no ejecutables (ej. Volantes PDF).
     */
    public function uploadDocument(UploadedFile $file, string $directory = 'documents'): string
    {
        $allowedMimes = ['application/pdf'];
        if (! in_array($file->getMimeType(), $allowedMimes)) {
            throw new \InvalidArgumentException('Solo se admiten documentos en formato PDF.');
        }

        $filename = Str::uuid()->toString() . '.pdf';
        $fullPath = trim($directory, '/') . '/' . $filename;

        Storage::disk('public')->putFileAs(trim($directory, '/'), $file, $filename);

        return $fullPath;
    }
}
