<?php

namespace App\Filament\Resources\Pages\Pages;

use App\Filament\Resources\Pages\PageResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;

class EditPage extends EditRecord
{
    protected static string $resource = PageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('visitar')
                ->label('Ver en Web')
                ->icon(Heroicon::OutlinedArrowTopRightOnSquare)
                ->color('gray')
                ->url(fn (): string => $this->getRecord()->slug === 'inicio' ? url('/') : url('/' . $this->getRecord()->slug))
                ->openUrlInNewTab(),

            $this->getSaveFormAction()
                ->label('Guardar Cambios')
                ->icon(Heroicon::OutlinedCheckCircle)
                ->color('primary'),

            DeleteAction::make()
                ->label('Mover a Papelera')
                ->icon(Heroicon::OutlinedTrash)
                ->hidden(fn (): bool => $this->getRecord()->slug === 'inicio'),

            ForceDeleteAction::make()
                ->label('Eliminar Definitivo')
                ->hidden(fn (): bool => $this->getRecord()->slug === 'inicio'),

            RestoreAction::make()
                ->label('Restaurar Página')
                ->icon(Heroicon::OutlinedArrowUturnLeft)
                ->color('success'),
        ];
    }
}
