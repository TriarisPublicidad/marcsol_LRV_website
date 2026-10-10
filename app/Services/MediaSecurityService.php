<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use InvalidArgumentException;

class MediaSecurityService
{
    /**
     * Extensiones permitidas agrupadas por categoría (Whitelist estricta).
     */
    protected const ALLOWED_EXTENSIONS = [
        'imagen' => ['jpg', 'jpeg', 'png', 'webp', 'svg', 'avif', 'gif'],
        'pdf' => ['pdf'],
        'video' => ['mp4', 'webm', 'mov'],
    ];

    /**
     * Tipos MIME permitidos.
     */
    protected const ALLOWED_MIMES = [
        'image/jpeg',
        'image/png',
        'image/webp',
        'image/svg+xml',
        'image/avif',
        'image/gif',
        'application/pdf',
        'video/mp4',
        'video/webm',
        'video/quicktime',
    ];

    /**
     * Extensiones ejecutables y peligrosas bloqueadas permanentemente.
     */
    protected const BLOCKED_EXTENSIONS = [
        'php', 'phtml', 'php3', 'php4', 'php5', 'php7', 'php8', 'phps', 'phar',
        'exe', 'bat', 'cmd', 'sh', 'bash', 'bin', 'dll', 'so',
        'js', 'jsp', 'vbs', 'asp', 'aspx', 'cgi', 'pl', 'py',
        'htaccess', 'htpasswd', 'env', 'config',
    ];

    /**
     * Valida la seguridad de un archivo antes de procesarlo.
     */
    public static function validateFile(string $originalName, ?string $mimeType = null): void
    {
        $normalizedName = strtolower($originalName);

        // 1. Detección de null bytes o secuencias de escape
        if (str_contains($normalizedName, chr(0)) || str_contains($normalizedName, '..')) {
            throw new InvalidArgumentException('Nombre de archivo no válido o sospechoso.');
        }

        // 2. Detección de dobles extensiones (ej. avatar.php.png o exploit.phar.jpg)
        $parts = explode('.', $normalizedName);
        if (count($parts) > 1) {
            foreach ($parts as $part) {
                if (in_array($part, self::BLOCKED_EXTENSIONS, true)) {
                    throw new InvalidArgumentException('El archivo contiene una extensión no permitida o peligrosa.');
                }
            }
        }

        // 3. Validación de extensión final
        $ext = end($parts);
        $allAllowed = array_merge(...array_values(self::ALLOWED_EXTENSIONS));
        if (! in_array($ext, $allAllowed, true)) {
            throw new InvalidArgumentException("La extensión .{$ext} no está permitida en la biblioteca de medios.");
        }

        // 4. Validación de tipo MIME
        if ($mimeType && ! in_array($mimeType, self::ALLOWED_MIMES, true)) {
            throw new InvalidArgumentException("El tipo de archivo ({$mimeType}) no está autorizado por seguridad.");
        }
    }

    /**
     * Determina el tipo de medio a partir de su extensión.
     */
    public static function detectMediaType(string $extension): string
    {
        $ext = strtolower($extension);

        foreach (self::ALLOWED_EXTENSIONS as $tipo => $extensions) {
            if (in_array($ext, $extensions, true)) {
                return $tipo;
            }
        }

        return 'documento';
    }

    /**
     * Sanitiza un archivo SVG para neutralizar código JavaScript malicioso incrustado.
     */
    public static function sanitizeSvg(string $filePath, string $disk = 'public'): void
    {
        $storage = Storage::disk($disk);
        if (! $storage->exists($filePath)) {
            return;
        }

        $content = $storage->get($filePath);
        if (! $content) {
            return;
        }

        // Remover etiquetas <script> y eventos inline (onload, onclick, onerror, etc.)
        $sanitized = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $content);
        $sanitized = preg_replace('/\s*on\w+\s*=\s*(".*?"|\'.*?\'|[^\'">\s]+)/i', '', $sanitized);
        $sanitized = preg_replace('/javascript:/i', 'blocked:', $sanitized);

        $storage->put($filePath, $sanitized);
    }

    /**
     * Asegura que el subdirectorio físico exista con permisos adecuados (0775).
     */
    public static function ensureDirectoryExists(string $folder, string $disk = 'public'): void
    {
        $storage = Storage::disk($disk);
        if (! $storage->exists($folder)) {
            $storage->makeDirectory($folder);
        }

        $fullPath = $storage->path($folder);
        if (is_dir($fullPath) && ! str_starts_with(PHP_OS, 'WIN')) {
            @chmod($fullPath, 0775);
        }
    }

    /**
     * Genera un nombre de archivo normalizado y seguro basado en el nombre original:
     * - Remueve tildes y caracteres especiales mediante Str::slug().
     * - Reemplaza espacios por guiones medios (-).
     * - Convierte a minúsculas.
     * - Preserva extensión limpia.
     * - Si ya existe, añade un sufijo correlativo (-1, -2, etc.).
     */
    public static function generateSafeFileName(mixed $file, string $folder, string $disk = 'public'): string
    {
        self::ensureDirectoryExists($folder, $disk);

        $clientName = method_exists($file, 'getClientOriginalName') ? $file->getClientOriginalName() : 'archivo';
        $originalBase = pathinfo($clientName, PATHINFO_FILENAME);
        $extension = strtolower(pathinfo($clientName, PATHINFO_EXTENSION));

        // Normalizar con Str::slug (remueve tildes, caracteres raros y cambia espacios por -)
        $slug = Str::slug($originalBase);
        if (empty($slug)) {
            $slug = 'archivo';
        }

        $storage = Storage::disk($disk);
        $candidate = "{$slug}.{$extension}";
        $counter = 1;

        while ($storage->exists("{$folder}/{$candidate}")) {
            $candidate = "{$slug}-{$counter}.{$extension}";
            $counter++;
        }

        return $candidate;
    }

    /**
     * Extrae las dimensiones (ancho x alto) de una imagen de forma segura.
     */
    public static function getImageDimensions(string $filePath, string $disk = 'public'): array
    {
        $storage = Storage::disk($disk);
        if (! $storage->exists($filePath)) {
            return ['ancho' => null, 'alto' => null];
        }

        $fullPath = $storage->path($filePath);
        if (! file_exists($fullPath)) {
            return ['ancho' => null, 'alto' => null];
        }

        $info = @getimagesize($fullPath);
        if ($info && isset($info[0], $info[1])) {
            return ['ancho' => $info[0], 'alto' => $info[1]];
        }

        return ['ancho' => null, 'alto' => null];
    }
}

