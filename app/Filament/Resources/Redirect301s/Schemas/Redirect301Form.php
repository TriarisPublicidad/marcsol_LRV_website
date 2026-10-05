<?php

namespace App\Filament\Resources\Redirect301s\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class Redirect301Form
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Configuración de Redirección 301 Permanente')
                    ->description('Gestiona las migraciones SEO sin perder autoridad ni enlaces rotos.')
                    ->columns(2)
                    ->components([
                        TextInput::make('url_origen')
                            ->label('URL de Origen')
                            ->placeholder('/ofertas-antiguas')
                            ->helperText('Ruta relativa que devolverá la redirección permanente 301.')
                            ->required(),

                        TextInput::make('url_destino')
                            ->label('URL de Destino')
                            ->placeholder('/promociones')
                            ->helperText('Ruta relativa o URL externa de destino.')
                            ->required(),

                        Toggle::make('status')
                            ->label('Redirección Activa')
                            ->helperText('Si se desactiva, la URL devolverá 404 en lugar de redirigir.')
                            ->default(true)
                            ->columnSpan(2),
                    ]),
            ]);
    }
}
