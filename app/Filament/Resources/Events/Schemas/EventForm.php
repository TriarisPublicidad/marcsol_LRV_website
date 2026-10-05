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
                Section::make('Información del Evento o Activación')
                    ->components([
                        TextInput::make('titulo')
                            ->label('Título del Evento')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->unique(ignoreRecord: true),
                        DateTimePicker::make('fecha_evento')
                            ->label('Fecha y Hora del Evento')
                            ->required()
                            ->default(now()->addDays(2)),
                        TextInput::make('lugar')
                            ->label('Lugar en Quevedo')
                            ->placeholder('Av. 7 de Octubre, Quevedo')
                            ->required(),
                        Select::make('branch_id')
                            ->relationship('branch', 'nombre')
                            ->label('Sucursal Vinculada (opcional)')
                            ->placeholder('Evento general o en todas las sucursales')
                            ->nullable()
                            ->searchable()
                            ->preload(),
                        Textarea::make('descripcion')
                            ->label('Descripción / Programa del Evento')
                            ->rows(4)
                            ->required(),
                        FileUpload::make('imagen')
                            ->label('Afiche / Flyer del Evento')
                            ->image()
                            ->directory('events')
                            ->disk('public'),
                        Toggle::make('status')
                            ->label('Evento Activo')
                            ->default(true),
                    ]),
            ]);
    }
}
