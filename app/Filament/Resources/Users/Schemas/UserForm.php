<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información del Usuario y Accesos')
                    ->description('Gestiona las credenciales de acceso al panel y los roles de seguridad.')
                    ->columns(2)
                    ->components([
                        TextInput::make('name')
                            ->label('Nombre Completo')
                            ->placeholder('Ej: Juan Pérez')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('email')
                            ->label('Correo Electrónico')
                            ->placeholder('usuario@marcsol.com.ec')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        TextInput::make('password')
                            ->label('Contraseña')
                            ->password()
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->helperText('Deja este campo vacío si no deseas modificar la contraseña.'),

                        Select::make('roles')
                            ->label('Rol en el Sistema (Permisos)')
                            ->relationship('roles', 'name')
                            ->multiple()
                            ->preload()
                            ->required(),
                    ]),
            ]);
    }
}
