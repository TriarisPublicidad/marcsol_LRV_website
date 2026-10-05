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
                    ->components([
                        TextInput::make('url_origen')
                            ->label('URL de Origen')
                            ->placeholder('/ofertas-antiguas')
                            ->helperText('Ruta relativa que devolverá la redirección permanente 301.')
                            ->required(),
                        TextInput::make('url_destino')
                            ->label('URL de Destino')
                            ->placeholder('/promociones')
                            ->helperText('Ruta relativa o URL externa a la que se dirigirá el usuario o bot de búsqueda.')
                            ->required(),
                        Toggle::make('status')
                            ->label('Redirección Activa')
                            ->default(true),
                    ]),
            ]);
    }
}
