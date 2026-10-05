<?php

namespace App\Filament\Resources\MenuItems\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MenuItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detalle del Elemento de Menú')
                    ->description('Configura los enlaces dinámicos de la barra de navegación y el pie de página.')
                    ->columns(2)
                    ->components([
                        TextInput::make('titulo')
                            ->label('Texto Visible del Enlace')
                            ->placeholder('Ej: Promociones')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('url')
                            ->label('Ruta o URL')
                            ->placeholder('/promociones o https://...')
                            ->required()
                            ->maxLength(255),

                        Select::make('ubicacion')
                            ->label('Ubicación del Menú')
                            ->options([
                                'header' => 'Header (Navegación Superior)',
                                'footer' => 'Footer (Pie de Página)',
                            ])
                            ->required()
                            ->default('header'),

                        Select::make('parent_id')
                            ->relationship('parent', 'titulo')
                            ->label('Elemento Padre (para Submenús)')
                            ->placeholder('Ninguno (Primer Nivel)')
                            ->nullable()
                            ->searchable()
                            ->preload(),

                        TextInput::make('orden')
                            ->label('Orden de Visualización')
                            ->numeric()
                            ->default(1)
                            ->required(),

                        Toggle::make('status')
                            ->label('Elemento Visible en el Menú')
                            ->default(true),
                    ]),
            ]);
    }
}
