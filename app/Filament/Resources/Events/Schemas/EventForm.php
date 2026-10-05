<?php

namespace App\Filament\Resources\Events\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class EventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Datos Principales del Evento')
                    ->description('Gestiona las actividades, degustaciones y ferias corporativas.')
                    ->columns(2)
                    ->components([
                        TextInput::make('titulo')
                            ->label('Título del Evento')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),

                        TextInput::make('slug')
                            ->label('Slug URL')
                            ->required()
                            ->unique(ignoreRecord: true),

                        DateTimePicker::make('fecha_evento')
                            ->label('Fecha y Hora del Evento')
                            ->required()
                            ->default(now()->addDays(2)),

                        Select::make('branch_id')
                            ->relationship('branch', 'nombre')
                            ->label('Sucursal Vinculada (Opcional)')
                            ->placeholder('Evento general o en todas las sucursales')
                            ->nullable()
                            ->searchable()
                            ->preload(),

                        TextInput::make('lugar')
                            ->label('Lugar en Quevedo')
                            ->placeholder('Av. 7 de Octubre, Quevedo')
                            ->required()
                            ->columnSpan(2),

                        Textarea::make('descripcion')
                            ->label('Descripción / Programa del Evento')
                            ->rows(4)
                            ->required()
                            ->columnSpan(2),
                    ]),

                Section::make('Afiche y Publicación')
                    ->description('Flyer promocional y estado de visibilidad en el portal.')
                    ->columns(2)
                    ->components([
                        FileUpload::make('imagen')
                            ->label('Afiche / Flyer del Evento')
                            ->image()
                            ->directory('events')
                            ->disk('public'),

                        Toggle::make('status')
                            ->label('Evento Activo y Publicado')
                            ->helperText('Visible en la cartelera de eventos y en la portada.')
                            ->default(true),
                    ]),
            ]);
    }
}
