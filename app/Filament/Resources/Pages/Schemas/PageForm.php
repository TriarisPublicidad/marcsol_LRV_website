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
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(12)
            ->components([
                // 1. NIVEL 1: 100% DEL ANCHO (Información Básica)
                Section::make('Identificación y Enlace de la Página')
                    ->description('Define el título principal y la ruta de acceso web.')
                    ->columnSpan(12)
                    ->columns(12)
                    ->components([
                        TextInput::make('titulo')
                            ->label('Título de la Página')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state)))
                            ->columnSpan(['default' => 12, 'md' => 7]),

                        TextInput::make('slug')
                            ->label('Ruta Web / Slug')
                            ->helperText('Usa "inicio" si esta página gobierna la Portada Principal (/).')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->columnSpan(['default' => 12, 'md' => 5]),
                    ]),

                // 2. NIVEL 2: COLUMNA IZQUIERDA (CONTENIDO Y PAGEBUILDER - 8 COLUMNAS)
                Group::make([
                    Section::make('Constructor Modular de Contenido (PageBuilder)')
                        ->description('Diseña la página agregando, organizando y reordenando bloques flexibles con las flechas de posición (▲ / ▼).')
                        ->components([
                            Builder::make('contenido_json_bloques')
                                ->label('Bloques de la Página')
                                ->blocks([
                                    Block::make('hero')
                                        ->label('🚀 Hero Principal / Banner Cabecera')
                                        ->schema([
                                            TextInput::make('titulo')->label('Título Principal')->required(),
                                            Textarea::make('subtitulo')->label('Subtítulo')->rows(2),
                                            TextInput::make('boton_texto')->label('Texto del Botón Principal (CTA)')->default('Explorar Ofertas'),
                                            TextInput::make('boton_url')->label('Enlace del Botón Principal')->default('/promociones'),
                                            FileUpload::make('imagen_fondo')->label('Imagen de Fondo (Opcional)')->image()->directory('pages')->disk('public'),
                                        ]),

                                    Block::make('promocion_del_dia')
                                        ->label('🔥 Promoción del Día Destacada')
                                        ->schema([
                                            TextInput::make('titulo')->label('Título del Bloque')->default('Promoción del Día'),
                                            TextInput::make('subtitulo')->label('Subtítulo')->default('Oferta especial por tiempo limitado en nuestras sucursales'),
                                        ]),

                                    Block::make('grid_promociones')
                                        ->label('🏷️ Catálogo / Grid de Promociones')
                                        ->schema([
                                            TextInput::make('titulo')->label('Título de la Sección')->default('Nuestras Ofertas Destacadas'),
                                            Textarea::make('subtitulo')->label('Subtítulo')->default('Ahorra en cada compra con nuestras ofertas semanales en Quevedo'),
                                            TextInput::make('limite')->label('Cantidad de Promociones a Mostrar')->numeric()->default(6),
                                            Toggle::make('solo_destacadas')->label('Mostrar solo promociones del día / destacadas')->default(false),
                                        ]),

                                    Block::make('eventos')
                                        ->label('📰 Noticias / Próximos Eventos y Activaciones')
                                        ->schema([
                                            TextInput::make('titulo')->label('Título de la Sección')->default('Próximos Eventos y Noticias en Quevedo'),
                                            Textarea::make('subtitulo')->label('Subtítulo')->default('Participa en degustaciones, activaciones y ferias en nuestras sucursales'),
                                            TextInput::make('limite')->label('Cantidad de Eventos a Mostrar')->numeric()->default(3),
                                        ]),

                                    Block::make('categorias')
                                        ->label('🛒 Secciones / Departamentos del Supermercado')
                                        ->schema([
                                            TextInput::make('titulo')->label('Título de la Sección')->default('Variedad en Todas las Secciones'),
                                            Textarea::make('subtitulo')->label('Subtítulo')->default('Explora nuestras categorías de productos seleccionados con calidad garantizada'),
                                        ]),

                                    Block::make('sucursales')
                                        ->label('📍 Nuestras Sucursales en Quevedo')
                                        ->schema([
                                            TextInput::make('titulo')->label('Título de la Sección')->default('Nuestras Sucursales en Quevedo'),
                                            Textarea::make('subtitulo')->label('Subtítulo')->default('Visítanos en cualquiera de nuestros 3 puntos estratégicos en la ciudad'),
                                        ]),

                                    Block::make('texto_imagen')
                                        ->label('💡 Sección Informativa (Texto con Imagen)')
                                        ->schema([
                                            TextInput::make('titulo')->label('Título')->required(),
                                            Textarea::make('contenido')->label('Contenido / Párrafo descriptivo')->rows(4)->required(),
                                            FileUpload::make('imagen')->label('Fotografía o Gráfico')->image()->directory('pages')->disk('public'),
                                            Select::make('posicion_imagen')
                                                ->label('Posición de la Imagen')
                                                ->options([
                                                    'izquierda' => 'Imagen a la Izquierda',
                                                    'derecha' => 'Imagen a la Derecha',
                                                ])
                                                ->default('derecha'),
                                        ]),

                                    Block::make('beneficios')
                                        ->label('⭐ Beneficios Corporativos (Por qué elegirnos)')
                                        ->schema([
                                            TextInput::make('titulo')->label('Título de la Sección')->default('¿Por qué comprar en Marcsol?'),
                                            Textarea::make('subtitulo')->label('Subtítulo')->default('Compromiso constante con la calidad, el ahorro y las familias de Quevedo'),
                                        ]),

                                    Block::make('faqs')
                                        ->label('❓ Preguntas Frecuentes (Acordeón FAQs)')
                                        ->schema([
                                            TextInput::make('titulo')->label('Título de la Sección FAQs')->default('Preguntas Frecuentes'),
                                            Repeater::make('items')
                                                ->label('Listado de Preguntas y Respuestas')
                                                ->schema([
                                                    TextInput::make('pregunta')->label('Pregunta')->required(),
                                                    Textarea::make('respuesta')->label('Respuesta')->rows(3)->required(),
                                                ])
                                                ->collapsible()
                                                ->defaultItems(2),
                                        ]),

                                    Block::make('banner_cta')
                                        ->label('📢 Banner de Llamado a la Acción (CTA)')
                                        ->schema([
                                            TextInput::make('titulo')->label('Título del Banner')->required(),
                                            Textarea::make('subtitulo')->label('Subtítulo o Mensaje')->rows(2),
                                            TextInput::make('boton_texto')->label('Texto del Botón')->default('Contáctanos por WhatsApp'),
                                            TextInput::make('boton_url')->label('Enlace del Botón')->default('https://wa.me/593997654321'),
                                        ]),
                                ])
                                ->collapsible()
                                ->cloneable(),
                        ]),
                ])
                ->columnSpan(['default' => 12, 'lg' => 8]),

                // 3. NIVEL 2: COLUMNA DERECHA (INSPECTOR LATERAL / CONFIG & SEO - 4 COLUMNAS)
                Group::make([
                    Section::make('Estado & Visibilidad')
                        ->components([
                            Toggle::make('status')
                                ->label('Página Activa / Publicada')
                                ->helperText('Al estar activa será accesible por los usuarios públicos.')
                                ->default(true),

                            Select::make('plantilla')
                                ->label('Plantilla de Diseño (Layout)')
                                ->options([
                                    'app' => 'Plantilla Corporativa Estándar (Header + Footer)',
                                    'landing' => 'Plantilla de Campaña / Landing (Cabecera y Pie Reducidos)',
                                ])
                                ->default('app')
                                ->required(),
                        ]),

                    Section::make('Optimización SEO / AEO')
                        ->description('Metadatos para posicionamiento orgánico en motores de búsqueda.')
                        ->components([
                            TextInput::make('meta_title')
                                ->label('Meta Title')
                                ->placeholder('Marcsol | Título de la página')
                                ->helperText('Título optimizado para Google (máx 70 car.)')
                                ->maxLength(70),

                            Textarea::make('meta_description')
                                ->label('Meta Description')
                                ->rows(3)
                                ->placeholder('Descripción atractiva para motores de búsqueda...')
                                ->helperText('Resumen descriptivo (máx 160 car.)')
                                ->maxLength(160),

                            FileUpload::make('og_image')
                                ->label('Imagen para Redes Sociales (OpenGraph)')
                                ->image()
                                ->directory('pages/og')
                                ->disk('public')
                                ->helperText('Aparecerá al compartir el enlace en WhatsApp, Facebook o Twitter (1200x630 px).'),
                        ]),
                ])
                ->columnSpan(['default' => 12, 'lg' => 4]),
            ]);
    }
}
