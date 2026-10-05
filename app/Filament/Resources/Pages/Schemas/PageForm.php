<?php

namespace App\Filament\Resources\Pages\Schemas;

use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información Básica')
                    ->components([
                        TextInput::make('titulo')
                            ->label('Título de la Página')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                        TextInput::make('slug')
                            ->label('Slug / URL')
                            ->required()
                            ->unique(ignoreRecord: true),
                        Toggle::make('status')
                            ->label('Página Publicada')
                            ->default(true),
                    ]),

                Section::make('Constructor Modular (PageBuilder)')
                    ->description('Diseña la página agregando bloques flexibles de contenido')
                    ->components([
                        Builder::make('bloques')
                            ->label('Bloques de la Página')
                            ->blocks([
                                Block::make('hero')
                                    ->label('Bloque Hero / Cabecera')
                                    ->schema([
                                        TextInput::make('titulo')->label('Título Principal')->required(),
                                        Textarea::make('subtitulo')->label('Subtítulo')->rows(2),
                                        TextInput::make('boton_texto')->label('Texto del Botón (CTA)'),
                                        TextInput::make('boton_url')->label('Enlace del Botón'),
                                    ]),

                                Block::make('texto_imagen')
                                    ->label('Bloque Texto e Imagen')
                                    ->schema([
                                        TextInput::make('titulo')->label('Título')->required(),
                                        Textarea::make('contenido')->label('Contenido / Párrafo')->rows(4)->required(),
                                        FileUpload::make('imagen')->label('Imagen')->image()->directory('pages')->disk('public'),
                                        Select::make('alineacion')
                                            ->label('Posición de la Imagen')
                                            ->options([
                                                'izquierda' => 'Imagen a la Izquierda',
                                                'derecha' => 'Imagen a la Derecha',
                                            ])
                                            ->default('derecha'),
                                    ]),

                                Block::make('grid_promociones')
                                    ->label('Bloque Grid de Ofertas')
                                    ->schema([
                                        TextInput::make('titulo')->label('Título de la Sección')->default('Nuestras Ofertas Destacadas'),
                                        TextInput::make('limite')->label('Cantidad de Ofertas a mostrar')->numeric()->default(6),
                                    ]),

                                Block::make('faqs')
                                    ->label('Bloque Preguntas Frecuentes (FAQs)')
                                    ->schema([
                                        TextInput::make('titulo')->label('Título de la Sección FAQs')->default('Preguntas Frecuentes'),
                                        Repeater::make('items')
                                            ->label('Listado de Preguntas')
                                            ->schema([
                                                TextInput::make('pregunta')->label('Pregunta')->required(),
                                                Textarea::make('respuesta')->label('Respuesta')->rows(3)->required(),
                                            ])
                                            ->collapsible()
                                            ->defaultItems(2),
                                    ]),
                            ])
                            ->collapsible(),
                    ]),

                Section::make('Optimización SEO / AEO')
                    ->components([
                        TextInput::make('meta_title')
                            ->label('Meta Title')
                            ->placeholder('Marcsol | Título Optimizado'),
                        Textarea::make('meta_description')
                            ->label('Meta Description')
                            ->rows(2)
                            ->placeholder('Descripción atractiva para motores de búsqueda (máx 160 caracteres).'),
                    ]),
            ]);
    }
}
