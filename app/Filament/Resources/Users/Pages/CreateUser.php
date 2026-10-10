<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Icons\Heroicon;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('volver')
                ->label('Volver a Usuarios')
                ->icon(Heroicon::OutlinedArrowLeft)
                ->color('gray')
                ->url(UserResource::getUrl('index')),
        ];
    }
}

