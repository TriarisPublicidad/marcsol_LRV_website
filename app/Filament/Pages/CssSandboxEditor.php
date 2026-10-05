<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\File;
use UnitEnum;

class CssSandboxEditor extends Page
{
    protected static string|UnitEnum|null $navigationGroup = 'SEO & Sistema';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCodeBracket;

    protected static ?string $navigationLabel = 'Editor CSS (Sandbox)';

    protected static ?string $title = 'Editor CSS Seguro (Sandbox)';

    protected static ?int $navigationSort = 3;

    protected string $view = 'filament.pages.css-sandbox-editor';

    public string $cssContent = '';

    public string $filePath = '';

    public function mount(): void
    {
        $this->filePath = public_path('css/custom-override.css');

        if (! File::exists(dirname($this->filePath))) {
            File::makeDirectory(dirname($this->filePath), 0755, true);
        }

        if (! File::exists($this->filePath)) {
            File::put($this->filePath, "/* Marcsol Custom CSS Override */\n");
        }

        $this->cssContent = File::get($this->filePath);
    }

    public static function canAccess(): bool
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        return $user && ($user->hasRole('SuperAdmin') || $user->hasRole('Administrador'));
    }

    public function save(): void
    {
        // Sandbox Estricto: La ruta es inmutable y siempre apunta exclusivamente a custom-override.css
        $targetFile = public_path('css/custom-override.css');

        // Sanitización básica: evitar inyecciones peligrosas de expresiones o javascript en CSS
        $content = str_ireplace(['<script', '</script', '<?php', '?>', 'javascript:', 'expression('], '/* blocked */', $this->cssContent);

        File::put($targetFile, $content);

        Notification::make()
            ->title('Estilos CSS actualizados')
            ->body('Los cambios en public/css/custom-override.css fueron guardados de forma segura.')
            ->success()
            ->send();
    }
}
