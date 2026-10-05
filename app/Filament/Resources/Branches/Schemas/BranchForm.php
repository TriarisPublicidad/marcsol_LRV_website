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
                Section::make('Información General y Contacto')
                    ->description('Detalles principales y datos de atención al público de la sucursal.')
                    ->columns(2)
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
                            ->maxLength(255)
                            ->columnSpan(2),

                        TextInput::make('telefono')
                            ->label('Teléfono de Contacto')
                            ->tel()
                            ->placeholder('+593 5 275 9000'),

                        TextInput::make('horarios')
                            ->label('Horarios de Atención')
                            ->placeholder('07:30 a 21:00')
                            ->default('Lunes a Sábado: 07:30 - 21:30 | Domingos: 08:00 - 20:00'),
                    ]),

                Section::make('Geolocalización GPS y Estado')
                    ->description('Coordenadas para mapas interactivos y visibilidad.')
                    ->columns(2)
                    ->components([
                        TextInput::make('latitud')
                            ->label('Latitud GPS')
                            ->numeric()
                            ->placeholder('-1.0254000'),

                        TextInput::make('longitud')
                            ->label('Longitud GPS')
                            ->numeric()
                            ->placeholder('-79.4642000'),

                        Toggle::make('status')
                            ->label('Sucursal Activa y Abierta al Público')
                            ->helperText('Si se desmarca, la sucursal no se mostrará en los directorios públicos.')
                            ->default(true)
                            ->columnSpan(2),
                    ]),
            ]);
    }
}
