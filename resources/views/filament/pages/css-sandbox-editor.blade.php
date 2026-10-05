<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Banner Informativo del Sandbox --}}
        <div class="p-5 bg-gradient-to-r from-amber-500/10 via-amber-500/5 to-transparent border border-amber-500/30 rounded-2xl flex items-start gap-4 backdrop-blur-sm">
            <div class="p-2.5 rounded-xl bg-amber-500/20 text-amber-600 dark:text-amber-400 flex-shrink-0">
                <x-filament::icon icon="heroicon-o-shield-check" class="w-6 h-6" />
            </div>
            <div class="space-y-1">
                <h4 class="text-sm font-bold text-amber-900 dark:text-amber-200">
                    Entorno Sandbox Protegido
                </h4>
                <p class="text-xs text-amber-800/90 dark:text-amber-300/90 leading-relaxed">
                    Las reglas escritas aquí se inyectan de forma segura al portal público a través de <code class="px-2 py-0.5 bg-amber-100 dark:bg-amber-950/80 rounded font-mono font-bold text-amber-700 dark:text-amber-300">public/css/custom-override.css</code>. No se permite código ejecutable (PHP/JS) ni rutas del servidor.
                </p>
            </div>
        </div>

        <form wire:submit="save" class="space-y-6">
            {{-- Panel de Referencia Rápida / Variables CSS Disponibles --}}
            <div class="p-4 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl shadow-sm space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 flex items-center gap-1.5">
                        <x-filament::icon icon="heroicon-m-swatch" class="w-4 h-4 text-marcsol-primary" />
                        Variables y Selectores CSS del Portal
                    </span>
                    <span class="text-[11px] text-gray-400">Haz clic en un selector para insertarlo en tus notas</span>
                </div>
                <div class="flex flex-wrap gap-2 text-xs">
                    <span class="px-2.5 py-1 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-lg font-mono border border-gray-200 dark:border-gray-700">
                        var(--color-marcsol-primary)
                    </span>
                    <span class="px-2.5 py-1 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-lg font-mono border border-gray-200 dark:border-gray-700">
                        var(--color-marcsol-secondary)
                    </span>
                    <span class="px-2.5 py-1 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-lg font-mono border border-gray-200 dark:border-gray-700">
                        .bg-marcsol-primary
                    </span>
                    <span class="px-2.5 py-1 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-lg font-mono border border-gray-200 dark:border-gray-700">
                        .bg-marcsol-secondary
                    </span>
                    <span class="px-2.5 py-1 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-lg font-mono border border-gray-200 dark:border-gray-700">
                        .hero-title
                    </span>
                </div>
            </div>

            {{-- Editor de Código --}}
            <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-gray-950 overflow-hidden shadow-lg">
                {{-- Barra de herramientas del Editor --}}
                <div class="px-5 py-3 bg-gray-900 border-b border-gray-800 flex items-center justify-between text-xs">
                    <div class="flex items-center gap-3">
                        <span class="inline-flex gap-1.5">
                            <span class="w-3 h-3 rounded-full bg-red-500/80 inline-block"></span>
                            <span class="w-3 h-3 rounded-full bg-amber-500/80 inline-block"></span>
                            <span class="w-3 h-3 rounded-full bg-emerald-500/80 inline-block"></span>
                        </span>
                        <span class="font-mono text-gray-400 pl-2 border-l border-gray-800">
                            custom-override.css
                        </span>
                    </div>

                    <div class="flex items-center gap-4 text-gray-400 font-mono text-[11px]">
                        <span class="flex items-center gap-1.5 text-emerald-400 font-medium">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            Sintaxis CSS3
                        </span>
                        <span>UTF-8</span>
                    </div>
                </div>

                {{-- Textarea con espaciado generoso --}}
                <div class="p-6">
                    <textarea
                        wire:model="cssContent"
                        rows="22"
                        spellcheck="false"
                        class="block w-full font-mono text-sm leading-relaxed p-4 bg-gray-950 text-emerald-400 border border-gray-800 rounded-xl focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 resize-y outline-none tracking-wide"
                        placeholder="/* Escribe tus reglas de estilos CSS personalizados aquí... */&#10;&#10;.mi-clase-personalizada {&#10;    /* estilos */&#10;}"
                    ></textarea>
                </div>

                {{-- Pie del Editor --}}
                <div class="px-6 py-4 bg-gray-900/60 border-t border-gray-800 flex items-center justify-between">
                    <span class="text-xs text-gray-500">
                        Los cambios impactan inmediatamente en el frontend del sitio web.
                    </span>

                    <x-filament::button
                        type="submit"
                        size="lg"
                        icon="heroicon-m-check-circle"
                        color="primary"
                    >
                        Guardar y Aplicar Estilos CSS
                    </x-filament::button>
                </div>
            </div>
        </form>
    </div>
</x-filament-panels::page>

