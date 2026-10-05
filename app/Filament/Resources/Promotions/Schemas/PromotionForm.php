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
                Section::make('Información de la Promoción')
                    ->components([
                        TextInput::make('titulo')
                            ->label('Título de la Oferta')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->unique(ignoreRecord: true),
                        Select::make('category_id')
                            ->relationship('category', 'nombre')
                            ->label('Categoría')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Select::make('branch_id')
                            ->relationship('branch', 'nombre')
                            ->label('Sucursal (opcional)')
                            ->placeholder('Aplica a todas las sucursales')
                            ->nullable()
                            ->searchable()
                            ->preload(),
                        Textarea::make('descripcion')
                            ->label('Descripción / Beneficio de la Promoción')
                            ->required()
                            ->rows(3),
                        FileUpload::make('imagen')
                            ->label('Arte / Banner de Promoción')
                            ->image()
                            ->directory('promotions')
                            ->disk('public'),
                        DatePicker::make('fecha_inicio')
                            ->label('Fecha de Inicio')
                            ->default(now())
                            ->required(),
                        DatePicker::make('fecha_fin')
                            ->label('Fecha de Fin')
                            ->default(now()->addDays(7))
                            ->required(),
                        Toggle::make('es_promocion_del_dia')
                            ->label('Destacar como Oferta del Día (Hero)')
                            ->default(false),
                        Toggle::make('status')
                            ->label('Promoción Activa')
                            ->default(true),
                    ]),
            ]);
    }
}
