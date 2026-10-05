<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detalles de Categoría')
                    ->description('Gestiona las secciones de productos y departamentos del supermercado.')
                    ->columns(2)
                    ->components([
                        TextInput::make('nombre')
                            ->label('Nombre de Categoría')
                            ->placeholder('Ej: Carnes y Embutidos')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),

                        TextInput::make('slug')
                            ->label('Slug URL')
                            ->required()
                            ->unique(ignoreRecord: true),

                        Textarea::make('descripcion')
                            ->label('Descripción de la Categoría')
                            ->placeholder('Breve descripción de los productos incluidos en este departamento...')
                            ->rows(3)
                            ->columnSpan(2),

                        Toggle::make('status')
                            ->label('Categoría Activa')
                            ->helperText('Visible en filtros y en los bloques de la portada.')
                            ->default(true)
                            ->columnSpan(2),
                    ]),
            ]);
    }
}
