<?php

namespace App\Filament\Resources\ActivityLogs;

use App\Filament\Resources\ActivityLogs\Pages\ListActivityLogs;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Spatie\Activitylog\Models\Activity;

use UnitEnum;

class ActivityLogResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentMagnifyingGlass;

    protected static UnitEnum|string|null $navigationGroup = 'Seguridad & Control';

    protected static ?string $modelLabel = 'Registro de Actividad';

    protected static ?string $pluralModelLabel = 'Auditoría / Logs';

    protected static ?string $navigationLabel = 'Auditoría / Logs';

    protected static ?int $navigationSort = 2;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label('Fecha / Hora')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable(),

                TextColumn::make('description')
                    ->label('Evento')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'created' => 'Creado',
                        'updated' => 'Actualizado',
                        'deleted' => 'Eliminado',
                        default => ucfirst($state),
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'created' => 'success',
                        'updated' => 'info',
                        'deleted' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('subject_type')
                    ->label('Modelo Afectado')
                    ->formatStateUsing(fn ($state) => class_basename($state))
                    ->badge()
                    ->color('gray'),

                TextColumn::make('subject_id')
                    ->label('ID Registro')
                    ->sortable(),

                TextColumn::make('causer.name')
                    ->label('Usuario Responsable')
                    ->placeholder('Sistema / Automático')
                    ->searchable(),

                TextColumn::make('properties')
                    ->label('Atributos Modificados')
                    ->formatStateUsing(function ($state, Activity $record): string {
                        $props = $record->properties;
                        if (! $props) {
                            return 'Sin detalles';
                        }

                        $attributes = $props->get('attributes', []);
                        $old = $props->get('old', []);

                        if (! empty($old) && ! empty($attributes)) {
                            $diff = array_keys(array_diff_assoc($attributes, $old));
                            return ! empty($diff) ? implode(', ', $diff) : implode(', ', array_keys($attributes));
                        }

                        if (! empty($attributes)) {
                            return implode(', ', array_keys($attributes));
                        }

                        if (! empty($old)) {
                            return implode(', ', array_keys($old));
                        }

                        return 'Sin atributos';
                    })
                    ->limit(60)
                    ->tooltip(fn ($state, Activity $record) => 'Haz clic en "Ver Cambios" para inspeccionar'),
            ])
            ->recordActions([
                \Filament\Actions\Action::make('ver_cambios')
                    ->label('Ver Cambios')
                    ->icon(Heroicon::OutlinedEye)
                    ->color('primary')
                    ->modalHeading(fn (Activity $record) => 'Detalle de Auditoría: ' . class_basename($record->subject_type) . ' #' . $record->subject_id)
                    ->modalDescription(fn (Activity $record) => 'Evento "' . ucfirst($record->description) . '" por ' . ($record->causer?->name ?? 'Sistema Automático') . ' el ' . $record->created_at->format('d/m/Y H:i:s'))
                    ->modalContent(function (Activity $record) {
                        $props = $record->properties;
                        $attributes = $props ? $props->get('attributes', []) : [];
                        $old = $props ? $props->get('old', []) : [];

                        return view('filament.components.activity-log-diff', [
                            'record' => $record,
                            'attributes' => $attributes,
                            'old' => $old,
                        ]);
                    })
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Cerrar Ventana'),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListActivityLogs::route('/'),
        ];
    }
}
