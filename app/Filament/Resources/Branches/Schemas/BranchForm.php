<?php

namespace App\Filament\Resources\Branches\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class BranchForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Datos Principales de la Sucursal')
                    ->components([
                        TextInput::make('nombre')
                            ->label('Nombre de Sucursal')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                        TextInput::make('slug')
                            ->label('Slug URL')
                            ->required()
                            ->unique(ignoreRecord: true),
                        TextInput::make('direccion')
                            ->label('Dirección en Quevedo')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('telefono')
                            ->label('Teléfono de Contacto')
                            ->tel(),
                        TextInput::make('horarios')
                            ->label('Horarios de Atención')
                            ->placeholder('07:30 a 21:00')
                            ->default('Lunes a Sábado: 07:30 - 21:30 | Domingos: 08:00 - 20:00'),
                        TextInput::make('latitud')
                            ->numeric()
                            ->placeholder('-1.0254000'),
                        TextInput::make('longitud')
                            ->numeric()
                            ->placeholder('-79.4642000'),
                        Toggle::make('status')
                            ->label('Sucursal Activa')
                            ->default(true),
                    ]),
            ]);
    }
}
