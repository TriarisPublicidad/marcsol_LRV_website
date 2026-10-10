<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class MediaPicker
{
    /**
     * Genera un bloque de selección dual (Archivo o URL) para cualquier modelo.
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

        $acceptedTypes = $isPdf
            ? ['application/pdf']
            : ['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml', 'image/avif', 'image/gif'];

        return Section::make($label)
            ->description($description)
            ->collapsible()
            ->columns(1)
            ->components([
                Select::make($origenField)
                    ->label('Método de Asignación')
                    ->options([
                        'archivo' => 'Subir Archivo Local (almacenado en /storage/media/' . $subfolder . ')',
                        'url' => 'Ingresar Enlace URL (relativa o absoluta externa)',
                    ])
                    ->default(function ($record) use ($fieldName) {
                        $val = $record?->{$fieldName} ?? '';

                        return (str_starts_with($val, 'http://') || str_starts_with($val, 'https://') || str_starts_with($val, '/storage/')) ? 'url' : 'archivo';
                    })
                    ->live(),

                FileUpload::make($fieldName)
                    ->label($isPdf ? 'Cargar Documento PDF' : 'Cargar Archivo de Imagen')
                    ->disk('public')
                    ->directory('media/' . $subfolder)
                    ->visibility('public')
                    ->maxSize(51200)
                    ->acceptedFileTypes($acceptedTypes)
                    ->helperText("El archivo se guardará de forma segura en /storage/media/{$subfolder}/")
                    ->visible(fn ($get) => ($get($origenField) ?? 'archivo') === 'archivo'),

                TextInput::make($urlInputField)
                    ->label('Enlace URL')
                    ->placeholder('https://ejemplo.com/recurso.' . ($isPdf ? 'pdf' : 'webp') . ' o /storage/media/...')
                    ->helperText('Puedes ingresar una URL externa completa o una ruta relativa de /storage/media/')
                    ->visible(fn ($get) => $get($origenField) === 'url')
                    ->live(onBlur: true)
                    ->afterStateHydrated(function (TextInput $component, $state, $record) use ($fieldName) {
                        $val = $record?->{$fieldName} ?? '';
                        if (str_starts_with($val, 'http://') || str_starts_with($val, 'https://') || str_starts_with($val, '/storage/')) {
                            $component->state($val);
                        }
                    })
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

        if (($data[$origenField] ?? null) === 'url' && ! empty($data[$urlInputField])) {
            $data[$fieldName] = $data[$urlInputField];
        }

        unset($data[$origenField], $data[$urlInputField]);

        return $data;
    }
}
