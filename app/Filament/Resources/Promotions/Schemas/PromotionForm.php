<?php

namespace App\Filament\Resources\Promotions\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PromotionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detalles Principales de la Oferta')
                    ->description('Define los productos, precios y sucursal de aplicación.')
                    ->columns(2)
                    ->components([
                        TextInput::make('titulo')
                            ->label('Título de la Oferta')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),

                        TextInput::make('slug')
                            ->label('Slug URL')
                            ->required()
                            ->unique(ignoreRecord: true),

                        Select::make('category_id')
                            ->relationship('category', 'nombre')
                            ->label('Categoría / Departamento')
                            ->required()
                            ->searchable()
                            ->preload(),

                        Select::make('branch_id')
                            ->relationship('branch', 'nombre')
                            ->label('Sucursal Específica (Opcional)')
                            ->placeholder('Aplica a todas las sucursales')
                            ->nullable()
                            ->searchable()
                            ->preload(),

                        Textarea::make('descripcion')
                            ->label('Descripción / Beneficio de la Promoción')
                            ->required()
                            ->rows(3)
                            ->columnSpan(2),
                    ]),

                Section::make('Vigencia y Visibilidad')
                    ->description('Configura las fechas límites y si debe ser oferta del día.')
                    ->columns(2)
                    ->components([
                        DatePicker::make('fecha_inicio')
                            ->label('Fecha de Inicio')
                            ->default(now())
                            ->required(),

                        DatePicker::make('fecha_fin')
                            ->label('Fecha de Fin (Vencimiento)')
                            ->default(now()->addDays(7))
                            ->required(),

                        Toggle::make('es_promocion_del_dia')
                            ->label('Destacar como Oferta del Día (Hero)')
                            ->helperText('Aparecerá en el banner principal de la portada.')
                            ->default(false),

                        Toggle::make('status')
                            ->label('Promoción Activa')
                            ->helperText('Si se desmarca, no aparecerá en el portal web.')
                            ->default(true),
                    ]),

                Section::make('Arte Publicitario y Material Promocional')
                    ->description('Fotografía del producto, banner panorámico para encabezados y volante PDF descargable.')
                    ->columns(2)
                    ->components([
                        FileUpload::make('imagen')
                            ->label('Fotografía del Producto / Arte (Cuadrado o Vertical)')
                            ->image()
                            ->directory('promotions')
                            ->disk('public')
                            ->imageEditor()
                            ->helperText('Visible en tarjetas de catálogo y portada.'),

                        FileUpload::make('banner')
                            ->label('Banner Horizontal / Panorámico (Cabecera)')
                            ->image()
                            ->directory('promotions/banners')
                            ->disk('public')
                            ->imageEditor()
                            ->helperText('Visible en el encabezado de detalle de la oferta (16:9 o 21:9).'),

                        FileUpload::make('pdf_volante')
                            ->label('Volante / Catálogo de Ofertas en PDF (Descargable)')
                            ->acceptedFileTypes(['application/pdf'])
                            ->directory('promotions/volantes')
                            ->disk('public')
                            ->columnSpan(2)
                            ->helperText('Los clientes podrán descargar este PDF desde la página de la promoción.'),
                    ]),
            ]);
    }
}
