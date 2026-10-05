<x-filament-panels::page>
    <div class="space-y-6">
        <div class="p-4 bg-amber-50 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800 rounded-lg flex items-start space-x-3">
            <x-filament::icon icon="heroicon-o-shield-check" class="w-6 h-6 text-amber-600 dark:text-amber-400 flex-shrink-0 mt-0.5" />
            <div class="text-sm text-amber-800 dark:text-amber-200">
                <span class="font-bold">Modo Sandbox Activo:</span> Este editor estÃ¡ estrictamente restringido al archivo <code class="px-1.5 py-0.5 bg-amber-100 dark:bg-amber-900 rounded font-mono text-xs">public/css/custom-override.css</code>. No se permite la ediciÃ³n ni subida de archivos PHP, scripts de servidor o rutas fuera del Sandbox.
            </div>
        </div>

        <form wire:submit="save" class="space-y-4">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-3 bg-gray-50 dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <span class="font-mono text-xs text-gray-500 dark:text-gray-400">Archivo: /css/custom-override.css</span>
                    <span class="text-xs text-green-600 dark:text-green-400 font-medium">â— Sandbox Seguro</span>
                </div>

                <textarea wire:model="cssContent" rows="18"
                    class="block w-full font-mono text-xs p-4 bg-gray-950 text-emerald-400 border-0 focus:ring-0 resize-y"
                    placeholder="/* Escribe aquÃ­ tus reglas CSS personalizadas */"></textarea>
            </div>

            <div class="flex justify-end space-x-3">
                <x-filament::button type="submit" size="lg" icon="heroicon-m-check">
                    Guardar Estilos CSS
                </x-filament::button>
            </div>
        </form>
    </div>
</x-filament-panels::page>
