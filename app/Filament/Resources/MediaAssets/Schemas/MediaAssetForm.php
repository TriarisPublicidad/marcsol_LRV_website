<?php

namespace App\Filament\Resources\MediaAssets\Schemas;

use App\Services\MediaSecurityService;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class MediaAssetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Archivo y Ubicación')
                    ->description('Los archivos se almacenan de forma segura en /storage/media/ dentro de la subcarpeta seleccionada.')
                    ->columns(2)
                    ->components([
                        Select::make('carpeta')
                            ->label('Subcarpeta de Organización')
                            ->options([
                                'general' => 'general (recursos globales)',
                                'sucursales' => 'sucursales (fotografías de locales)',
                                'promociones' => 'promociones (banners y piezas)',
                                'eventos' => 'eventos (afiches y portadas)',
                                'paginas' => 'paginas (bloques web y OG images)',
                                'documentos' => 'documentos (catálogos y volantes PDF)',
                                'videos' => 'videos (clips y material audiovisual)',
                            ])
                            ->default('general')
                            ->required()
                            ->searchable()
                            ->createOptionForm([
                                TextInput::make('nombre_carpeta')
                                    ->label('Nombre de la Nueva Subcarpeta')
                                    ->placeholder('ej. marcas-aliadas')
                                    ->required()
                                    ->regex('/^[a-z0-9\-_]+$/')
                                    ->helperText('Solo letras minúsculas, números, guiones y sin espacios.'),
                            ])
                            ->createOptionUsing(fn (array $data): string => Str::slug($data['nombre_carpeta'])),

                        FileUpload::make('archivo')
                            ->label('Seleccionar Archivo')
                            ->disk('public')
                            ->directory(fn ($get) => 'media/' . ($get('carpeta') ?: 'general'))
                            ->visibility('public')
                            ->maxSize(51200) // 50MB
                            ->acceptedFileTypes([
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
                            ])
                            ->required()
                            ->columnSpanFull()
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                if (! $state) {
                                    return;
                                }

                                $filename = is_string($state) ? basename($state) : '';
                                $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

                                $tipo = MediaSecurityService::detectMediaType($ext);
                                $set('tipo', $tipo);

                                if (empty($get('titulo')) && $filename) {
                                    $cleanName = pathinfo($filename, PATHINFO_FILENAME);
                                    $cleanTitle = ucwords(str_replace(['-', '_'], ' ', $cleanName));
                                    $set('titulo', $cleanTitle);

                                    if (empty($get('alt')) && $tipo === 'imagen') {
                                        $set('alt', $cleanTitle);
                                    }
                                }
                            }),
                    ]),

                Section::make('Metadatos SEO & AEO')
                    ->description('Optimización semántica para motores de búsqueda tradicionales e inteligencia artificial.')
                    ->columns(2)
                    ->components([
                        TextInput::make('titulo')
                            ->label('Título / Nombre del Recurso')
                            ->placeholder('Ej. Fachada Principal Sucursal Quevedo Centro')
                            ->required()
                            ->maxLength(255),

                        Select::make('tipo')
                            ->label('Tipo de Recurso')
                            ->options([
                                'imagen' => 'Imagen',
                                'pdf' => 'Documento PDF',
                                'video' => 'Video',
                                'documento' => 'Otro Documento',
                            ])
                            ->default('imagen')
                            ->required(),

                        TextInput::make('alt')
                            ->label('Texto Alternativo (Alt Text - Accesibilidad y SEO)')
                            ->placeholder('Descripción detallada de la imagen para lectores de pantalla y Google Imágenes')
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Textarea::make('descripcion')
                            ->label('Descripción Semántica (Contexto AEO)')
                            ->placeholder('Contexto detallado para motores de búsqueda de IA (productos, ofertas, detalles del local)...')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
