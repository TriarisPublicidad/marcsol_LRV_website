<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Support\Icons\Heroicon;
use BackedEnum;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationLabel = 'Panel Principal';

    protected static ?string $title = 'Panel Principal - Marcsol';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHome;
}
