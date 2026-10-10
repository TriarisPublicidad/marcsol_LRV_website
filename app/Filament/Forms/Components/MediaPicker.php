<?php

namespace App\Filament\Forms\Components;

use App\Services\MediaSecurityService;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\HtmlString;

class MediaPicker
{
    /**
     * Genera un bloque de selección dual (Archivo o URL) con previsualización
     * y flujo de reemplazo para cualquier modelo.
     */
    public static function make(
        string $fieldName = 'imagen',
        string $label = 'Fotografía / Imagen',
        string $subfolder = 'sucursales',
        string $description = 'Sube un archivo a media o proporciona una URL (relativa o externa).',
        bool $isPdf = false
    ): Section {
        $origenField = "{$fieldName}_origen";
        $urlInputField = "{$fieldName}_url_input";
        $reemplazarField = "{$fieldName}_reemplazar";

        $acceptedTypes = $isPdf
            ? ['application/pdf']
            : ['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml', 'image/avif', 'image/gif'];

        return Section::make($label)
            ->description($description)
            ->collapsible()
            ->columns(1)
            ->components([
                // 1. Tarjeta de previsualización del recurso actual (si ya cuenta con una imagen)
                Placeholder::make("{$fieldName}_preview")
                    ->label('Recurso Actual Asignado')
                    ->content(function ($record) use ($fieldName, $isPdf): HtmlString {
                        $val = $record?->{$fieldName} ?? '';
                        if (empty($val)) {
                            return new HtmlString('');
                        }

                        $url = $record?->{"{$fieldName}_url"}
                            ?? (str_starts_with($val, 'http://') || str_starts_with($val, 'https://')
                                ? $val
                                : asset('storage/' . ltrim(preg_replace('#^/?storage/#', '', $val), '/')));

                        $previewHtml = $isPdf
                            ? '<div class="w-16 h-16 rounded-xl bg-red-50 text-red-600 flex items-center justify-center font-bold text-xs uppercase border border-red-200">PDF</div>'
                            : '<img src="' . e($url) . '" alt="Vista previa" class="w-16 h-16 object-cover rounded-xl border border-gray-200 shadow-sm" onerror="this.src=\'' . asset('images/media-placeholder.svg') . '\'">';

                        return new HtmlString('
                            <div class="flex items-center gap-4 p-3.5 bg-gray-50 rounded-2xl border border-gray-200">
                                <div class="flex-shrink-0">
                                    ' . $previewHtml . '
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-bold text-gray-900 truncate">' . e(basename($val)) . '</p>
                                    <p class="text-[11px] text-gray-500 truncate mt-0.5">' . e($val) . '</p>
                                    <p class="text-[10px] text-emerald-600 font-semibold mt-1">● Recurso actualmente activo y vigente</p>
                                </div>
                            </div>
                        ');
                    })
                    ->visible(fn ($get, $record) => filled($record?->{$fieldName}) && ! $get($reemplazarField)),

                // 2. Botón "Click Aquí para reemplazar"
                Actions::make([
                    Action::make("reemplazar_{$fieldName}")
                        ->label('Click Aquí para reemplazar')
                        ->icon(Heroicon::OutlinedArrowPath)
                        ->color('warning')
                        ->action(function (callable $set) use ($fieldName, $origenField, $reemplazarField) {
                            $set($reemplazarField, true);
                            $set($origenField, null);
                        }),
                ])
                ->visible(fn ($get, $record) => filled($record?->{$fieldName}) && ! $get($reemplazarField)),

                // 3. Botón para cancelar el reemplazo y conservar la imagen vigente
                Actions::make([
                    Action::make("cancelar_reemplazo_{$fieldName}")
                        ->label('Cancelar reemplazo y conservar imagen vigente')
                        ->icon(Heroicon::OutlinedXMark)
                        ->color('gray')
                        ->action(function (callable $set) use ($fieldName, $origenField, $urlInputField, $reemplazarField) {
                            $set($reemplazarField, false);
                            $set($origenField, null);
                            $set($urlInputField, null);
                            $set($fieldName, null);
                        }),
                ])
                ->visible(fn ($get, $record) => filled($record?->{$fieldName}) && (bool) $get($reemplazarField)),

                // 4. Campo de estado oculto para controlar si se está reemplazando
                Hidden::make($reemplazarField)
                    ->default(false),

                // 5. Selector de método de asignación (Opción 2: inicia en null con placeholder)
                Select::make($origenField)
                    ->label('Método de Asignación')
                    ->placeholder('Seleccione una opción')
                    ->options([
                        'archivo' => 'Subir Archivo Local (almacenado en /storage/media/' . $subfolder . ')',
                        'url' => 'Ingresar Enlace URL (relativa o absoluta externa)',
                    ])
                    ->default(null)
                    ->live()
                    ->visible(fn ($get, $record) => blank($record?->{$fieldName}) || (bool) $get($reemplazarField)),

                // 6. Caja de subida de archivo (solo visible si origen es 'archivo')
                FileUpload::make($fieldName)
                    ->label($isPdf ? 'Cargar Documento PDF' : 'Cargar Archivo de Imagen')
                    ->disk('public')
                    ->directory('media/' . $subfolder)
                    ->visibility('public')
                    ->maxSize(51200)
                    ->acceptedFileTypes($acceptedTypes)
                    ->getUploadedFileNameForStorageUsing(function ($file) use ($subfolder): string {
                        $folder = 'media/' . $subfolder;

                        return MediaSecurityService::generateSafeFileName($file, $folder, 'public');
                    })
                    ->helperText("El archivo se guardará de forma segura en /storage/media/{$subfolder}/")
                    ->visible(fn ($get, $record) => (blank($record?->{$fieldName}) || (bool) $get($reemplazarField)) && $get($origenField) === 'archivo'),

                // 7. Caja de enlace URL (solo visible si origen es 'url')
                TextInput::make($urlInputField)
                    ->label('Enlace URL')
                    ->placeholder('https://ejemplo.com/recurso.' . ($isPdf ? 'pdf' : 'webp') . ' o /storage/media/...')
                    ->helperText('Puedes ingresar una URL externa completa o una ruta relativa de /storage/media/')
                    ->visible(fn ($get, $record) => (blank($record?->{$fieldName}) || (bool) $get($reemplazarField)) && $get($origenField) === 'url')
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set) use ($fieldName) {
                        if (! empty($state)) {
                            $set($fieldName, $state);
                        }
                    }),
            ]);
    }

    /**
     * Normaliza los datos antes de persistir en base de datos.
     */
    public static function mutateData(array $data, string $fieldName = 'imagen'): array
    {
        $origenField = "{$fieldName}_origen";
        $urlInputField = "{$fieldName}_url_input";
        $reemplazarField = "{$fieldName}_reemplazar";

        $isReemplazando = (bool) ($data[$reemplazarField] ?? false);

        if ($isReemplazando) {
            if (($data[$origenField] ?? null) === 'url' && ! empty($data[$urlInputField])) {
                $data[$fieldName] = $data[$urlInputField];
            }
        } else {
            // Si no está en proceso de reemplazo y el campo viene nulo o no se tocó en el formulario,
            // no sobreescribir la imagen existente
            if (array_key_exists($fieldName, $data) && empty($data[$fieldName])) {
                unset($data[$fieldName]);
            }
        }

        unset($data[$origenField], $data[$urlInputField], $data[$reemplazarField]);

        return $data;
    }
}
