<x-filament-panels::page>
    <form wire:submit="save" class="space-y-6">

        {{-- Pestañas Superiores Nativas de Filament --}}
        <x-filament::tabs contained label="Configuración General del Sitio">
            <x-filament::tabs.item
                :active="$activeTab === 'branding'"
                wire:click="$set('activeTab', 'branding')"
                icon="heroicon-m-paint-brush"
                badge="Marca"
            >
                Identidad & Branding
            </x-filament::tabs.item>

            <x-filament::tabs.item
                :active="$activeTab === 'tracking'"
                wire:click="$set('activeTab', 'tracking')"
                icon="heroicon-m-chart-bar-square"
                badge="Píxeles"
            >
                Data Tracking & Analítica
            </x-filament::tabs.item>

            <x-filament::tabs.item
                :active="$activeTab === 'seo'"
                wire:click="$set('activeTab', 'seo')"
                icon="heroicon-m-globe-alt"
                badge="Schema.org"
            >
                SEO Global & Metadatos
            </x-filament::tabs.item>
        </x-filament::tabs>

        {{-- ================================================================= --}}
        {{-- PESTAÑA 1: IDENTIDAD & BRANDING --}}
        {{-- ================================================================= --}}
        <div x-show="$wire.activeTab === 'branding'" class="space-y-6">

            {{-- 1.1 Información Corporativa --}}
            <x-filament::section
                icon="heroicon-m-building-storefront"
                heading="Datos Corporativos de la Empresa"
                description="Información general visible en el encabezado, pie de página y botones de contacto del portal web."
            >
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-950 dark:text-white">
                            Nombre Comercial <span class="text-danger-600">*</span>
                        </label>
                        <x-filament::input.wrapper prefix-icon="heroicon-m-building-storefront">
                            <x-filament::input
                                type="text"
                                wire:model="site_name"
                                placeholder="Marcsol"
                                required
                            />
                        </x-filament::input.wrapper>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-950 dark:text-white">
                            Eslogan Corporativo
                        </label>
                        <x-filament::input.wrapper prefix-icon="heroicon-m-sparkles">
                            <x-filament::input
                                type="text"
                                wire:model="site_tagline"
                                placeholder="Supermercado Corporativo"
                            />
                        </x-filament::input.wrapper>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-950 dark:text-white">
                            Teléfono PBX Central
                        </label>
                        <x-filament::input.wrapper prefix-icon="heroicon-m-phone">
                            <x-filament::input
                                type="text"
                                wire:model="company_phone"
                                placeholder="+593 5 275 9000"
                            />
                        </x-filament::input.wrapper>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-950 dark:text-white">
                            WhatsApp de Atención al Cliente
                        </label>
                        <x-filament::input.wrapper prefix-icon="heroicon-m-chat-bubble-oval-left-ellipsis">
                            <x-filament::input
                                type="text"
                                wire:model="company_whatsapp"
                                placeholder="+593 99 765 4321"
                            />
                        </x-filament::input.wrapper>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-950 dark:text-white">
                            Correo Electrónico de Contacto
                        </label>
                        <x-filament::input.wrapper prefix-icon="heroicon-m-envelope">
                            <x-filament::input
                                type="email"
                                wire:model="company_email"
                                placeholder="contacto@marcsol.com.ec"
                            />
                        </x-filament::input.wrapper>
                    </div>

                    <div class="space-y-2 md:col-span-3">
                        <label class="block text-sm font-medium text-gray-950 dark:text-white">
                            Dirección Principal de la Matriz (Quevedo)
                        </label>
                        <x-filament::input.wrapper prefix-icon="heroicon-m-map-pin">
                            <x-filament::input
                                type="text"
                                wire:model="company_address"
                                placeholder="Av. 7 de Octubre #402 y Calle Cuarta, Quevedo, Ecuador"
                            />
                        </x-filament::input.wrapper>
                    </div>
                </div>
            </x-filament::section>

            {{-- 1.2 Paleta de Colores Dinámica (:root CSS) --}}
            <x-filament::section
                icon="heroicon-m-swatch"
                heading="Paleta de Colores Corporativos (:root CSS)"
                description="Estos colores se inyectan automáticamente en la hoja de estilos global. Modifícalos con el selector visual o ingresa el código HEX."
            >
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    {{-- Color Primario --}}
                    <div class="p-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">Color Primario</span>
                            <span class="text-xs px-2 py-0.5 rounded-full bg-primary-100 text-primary-800 dark:bg-primary-950 dark:text-primary-300 font-mono font-medium" x-text="$wire.primary_color"></span>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Encabezados, barra de navegación superior y botones principales.</p>
                        
                        <div class="flex items-center space-x-3 pt-2">
                            <div class="relative w-12 h-12 rounded-lg shadow-sm border border-gray-300 dark:border-gray-600 overflow-hidden flex-shrink-0 cursor-pointer"
                                 :style="'background-color: ' + $wire.primary_color">
                                <input type="color" wire:model.live="primary_color" class="opacity-0 absolute inset-0 w-full h-full cursor-pointer">
                            </div>
                            <x-filament::input.wrapper class="w-full">
                                <x-filament::input
                                    type="text"
                                    wire:model.live="primary_color"
                                    class="font-mono text-xs uppercase"
                                    placeholder="#0F4C81"
                                />
                            </x-filament::input.wrapper>
                        </div>
                    </div>

                    {{-- Color Secundario --}}
                    <div class="p-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">Color Secundario</span>
                            <span class="text-xs px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300 font-mono font-medium" x-text="$wire.secondary_color"></span>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Insignias de promociones, botones de llamada a la acción y ofertas.</p>
                        
                        <div class="flex items-center space-x-3 pt-2">
                            <div class="relative w-12 h-12 rounded-lg shadow-sm border border-gray-300 dark:border-gray-600 overflow-hidden flex-shrink-0 cursor-pointer"
                                 :style="'background-color: ' + $wire.secondary_color">
                                <input type="color" wire:model.live="secondary_color" class="opacity-0 absolute inset-0 w-full h-full cursor-pointer">
                            </div>
                            <x-filament::input.wrapper class="w-full">
                                <x-filament::input
                                    type="text"
                                    wire:model.live="secondary_color"
                                    class="font-mono text-xs uppercase"
                                    placeholder="#F58220"
                                />
                            </x-filament::input.wrapper>
                        </div>
                    </div>

                    {{-- Color de Acento --}}
                    <div class="p-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">Color de Acento</span>
                            <span class="text-xs px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300 font-mono font-medium" x-text="$wire.accent_color"></span>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Etiquetas de ahorro, frescura de productos y confirmaciones de éxito.</p>
                        
                        <div class="flex items-center space-x-3 pt-2">
                            <div class="relative w-12 h-12 rounded-lg shadow-sm border border-gray-300 dark:border-gray-600 overflow-hidden flex-shrink-0 cursor-pointer"
                                 :style="'background-color: ' + $wire.accent_color">
                                <input type="color" wire:model.live="accent_color" class="opacity-0 absolute inset-0 w-full h-full cursor-pointer">
                            </div>
                            <x-filament::input.wrapper class="w-full">
                                <x-filament::input
                                    type="text"
                                    wire:model.live="accent_color"
                                    class="font-mono text-xs uppercase"
                                    placeholder="#2ECC71"
                                />
                            </x-filament::input.wrapper>
                        </div>
                    </div>
                </div>

                {{-- Barra de Demostración Visual de Colores --}}
                <div class="mt-4 p-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 flex flex-wrap items-center justify-between gap-4">
                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400 flex items-center gap-1.5">
                        <x-filament::icon icon="heroicon-m-eye" class="w-4 h-4 text-gray-400" />
                        Previsualización en vivo de botones y elementos:
                    </span>
                    <div class="flex flex-wrap items-center gap-3">
                        <button type="button" class="px-4 py-2 text-xs font-semibold text-white rounded-lg shadow transition" :style="'background-color: ' + $wire.primary_color">
                            Botón Primario
                        </button>
                        <button type="button" class="px-4 py-2 text-xs font-semibold text-white rounded-lg shadow transition" :style="'background-color: ' + $wire.secondary_color">
                            Promoción Destacada
                        </button>
                        <span class="px-3 py-1.5 text-xs font-bold text-white rounded-full shadow-sm" :style="'background-color: ' + $wire.accent_color">
                            100% Frescura
                        </span>
                    </div>
                </div>
            </x-filament::section>
        </div>

        {{-- ================================================================= --}}
        {{-- PESTAÑA 2: DATA TRACKING & PÍXELES --}}
        {{-- ================================================================= --}}
        <div x-show="$wire.activeTab === 'tracking'" class="space-y-6">

            <x-filament::section
                icon="heroicon-m-chart-bar-square"
                heading="Identificadores de Analítica y Medición"
                description="Ingresa únicamente los IDs correspondientes. Las etiquetas oficiales se inyectan en el HTML sanitizadas y protegidas."
            >
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Google Tag Manager --}}
                    <div class="p-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 space-y-2">
                        <div class="flex items-center justify-between">
                            <label class="text-sm font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                                Google Tag Manager (GTM)
                            </label>
                            <span class="text-xs text-gray-500 dark:text-gray-400 font-mono">GTM-XXXXXXX</span>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Contenedor central para Google Analytics 4 y conversiones de Ads.</p>
                        <x-filament::input.wrapper prefix-icon="heroicon-m-tag">
                            <x-filament::input
                                type="text"
                                wire:model="gtm_id"
                                placeholder="GTM-XXXXXXX"
                                class="font-mono text-sm"
                            />
                        </x-filament::input.wrapper>
                    </div>

                    {{-- Meta Pixel --}}
                    <div class="p-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 space-y-2">
                        <div class="flex items-center justify-between">
                            <label class="text-sm font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-indigo-500"></span>
                                Meta Pixel (Facebook & Instagram)
                            </label>
                            <span class="text-xs text-gray-500 dark:text-gray-400 font-mono">15-16 dígitos</span>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Medición de visitas, visualización de ofertas y públicos de remarketing.</p>
                        <x-filament::input.wrapper prefix-icon="heroicon-m-camera">
                            <x-filament::input
                                type="text"
                                wire:model="meta_pixel_id"
                                placeholder="123456789012345"
                                class="font-mono text-sm"
                            />
                        </x-filament::input.wrapper>
                    </div>

                    {{-- TikTok Pixel --}}
                    <div class="p-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 space-y-2">
                        <div class="flex items-center justify-between">
                            <label class="text-sm font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-pink-500"></span>
                                TikTok Pixel
                            </label>
                            <span class="text-xs text-gray-500 dark:text-gray-400 font-mono">ID Alfanumérico</span>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Seguimiento de conversiones y eventos para campañas en TikTok Ads.</p>
                        <x-filament::input.wrapper prefix-icon="heroicon-m-video-camera">
                            <x-filament::input
                                type="text"
                                wire:model="tiktok_pixel_id"
                                placeholder="CXXXXXXXXXXXXXXXXX"
                                class="font-mono text-sm"
                            />
                        </x-filament::input.wrapper>
                    </div>

                    {{-- Microsoft Clarity --}}
                    <div class="p-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 space-y-2">
                        <div class="flex items-center justify-between">
                            <label class="text-sm font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                                Microsoft Clarity
                            </label>
                            <span class="text-xs text-gray-500 dark:text-gray-400 font-mono">Código de Proyecto</span>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Mapas de calor (Heatmaps) y grabaciones anónimas de navegación.</p>
                        <x-filament::input.wrapper prefix-icon="heroicon-m-cursor-arrow-rays">
                            <x-filament::input
                                type="text"
                                wire:model="clarity_id"
                                placeholder="xxxxxxx"
                                class="font-mono text-sm"
                            />
                        </x-filament::input.wrapper>
                    </div>
                </div>

                {{-- Inyección de Scripts Personalizados --}}
                <div class="pt-6 border-t border-gray-200 dark:border-gray-700 space-y-6">
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <label class="block text-sm font-semibold text-gray-900 dark:text-white">
                                Scripts Personalizados en &lt;head&gt;
                            </label>
                            <span class="text-xs text-gray-500 dark:text-gray-400">Verificaciones de dominio o etiquetas meta</span>
                        </div>
                        <textarea
                            wire:model="custom_head_scripts"
                            rows="4"
                            class="block w-full font-mono text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-gray-950 text-emerald-400 shadow-sm focus:ring-primary-500 p-3"
                            placeholder="<!-- Meta tags de verificación (Google Search Console, Pinterest, etc.) -->"
                        ></textarea>
                    </div>

                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <label class="block text-sm font-semibold text-gray-900 dark:text-white">
                                Scripts Personalizados en el cierre de &lt;body&gt;
                            </label>
                            <span class="text-xs text-gray-500 dark:text-gray-400">Widgets de chat interactivo o scripts de conversión</span>
                        </div>
                        <textarea
                            wire:model="custom_body_scripts"
                            rows="4"
                            class="block w-full font-mono text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-gray-950 text-emerald-400 shadow-sm focus:ring-primary-500 p-3"
                            placeholder="<!-- Widgets de WhatsApp flotante, chat en vivo o scripts de remarketing -->"
                        ></textarea>
                    </div>
                </div>
            </x-filament::section>
        </div>

        {{-- ================================================================= --}}
        {{-- PESTAÑA 3: SEO GLOBAL & METADATOS --}}
        {{-- ================================================================= --}}
        <div x-show="$wire.activeTab === 'seo'" class="space-y-6">

            {{-- 3.1 Previsualización de Google SERP --}}
            <x-filament::section
                icon="heroicon-m-magnifying-glass"
                heading="Previsualización en Resultados de Búsqueda (Google Snippet)"
                description="Así es como los usuarios encontrarán a Marcsol en los resultados de Google."
            >
                <div class="p-5 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 shadow-sm max-w-3xl space-y-1.5">
                    <div class="flex items-center space-x-2 text-xs text-gray-600 dark:text-gray-400">
                        <span class="w-4 h-4 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-[9px]">M</span>
                        <span class="font-medium text-gray-800 dark:text-gray-200">Marcsol Supermercado</span>
                        <span>› quevedo</span>
                    </div>
                    <h4 class="text-lg font-medium text-blue-700 dark:text-blue-400 hover:underline cursor-pointer truncate"
                        x-text="$wire.meta_title_default || 'Marcsol | Supermercado Corporativo en Quevedo'"></h4>
                    <p class="text-xs text-gray-600 dark:text-gray-300 line-clamp-2 leading-relaxed"
                       x-text="$wire.meta_description_default || 'Descubre las mejores ofertas, promociones diarias y variedad de productos en Marcsol Supermercado Corporativo en Quevedo, Los Ríos.'"></p>
                </div>
            </x-filament::section>

            {{-- 3.2 Campos de Configuración SEO --}}
            <x-filament::section
                icon="heroicon-m-code-bracket-square"
                heading="Configuración de Metadatos y Schema.org"
                description="Estos datos se aplican de forma global y como fallback para páginas que no tengan metadatos individuales."
            >
                <div class="space-y-5">
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <label class="block text-sm font-semibold text-gray-900 dark:text-white">
                                Meta Título Predeterminado (Title Tag) <span class="text-danger-600">*</span>
                            </label>
                            <span class="text-xs text-gray-400">Recomendado: 50 a 60 caracteres</span>
                        </div>
                        <x-filament::input.wrapper prefix-icon="heroicon-m-pencil-square">
                            <x-filament::input
                                type="text"
                                wire:model.live="meta_title_default"
                                placeholder="Marcsol | Supermercado Corporativo en Quevedo"
                                required
                            />
                        </x-filament::input.wrapper>
                    </div>

                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <label class="block text-sm font-semibold text-gray-900 dark:text-white">
                                Meta Descripción Predeterminada (Meta Description) <span class="text-danger-600">*</span>
                            </label>
                            <span class="text-xs text-gray-400">Recomendado: 140 a 160 caracteres</span>
                        </div>
                        <textarea
                            wire:model.live="meta_description_default"
                            rows="3"
                            class="block w-full text-sm rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:ring-primary-500 p-3"
                            placeholder="Descubre las mejores ofertas, promociones diarias y variedad de productos de calidad en Marcsol Supermercado Corporativo en Quevedo..."
                            required
                        ></textarea>
                    </div>

                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <label class="block text-sm font-semibold text-gray-900 dark:text-white">
                                Tipo de Negocio en Schema.org (Microdatos Estructurados)
                            </label>
                            <span class="text-xs text-gray-400">Rich Snippets para Google Maps & Búsqueda</span>
                        </div>
                        <x-filament::input.wrapper prefix-icon="heroicon-m-tag">
                            <select wire:model="schema_type" class="block w-full border-0 bg-transparent py-1.5 pl-3 pr-8 text-sm focus:ring-0 dark:text-white">
                                <option value="Supermarket">Supermarket (Supermercado Corporativo - Recomendado)</option>
                                <option value="GroceryStore">GroceryStore (Tienda de Alimentos y Víveres)</option>
                                <option value="LocalBusiness">LocalBusiness (Negocio Local General)</option>
                            </select>
                        </x-filament::input.wrapper>
                    </div>
                </div>
            </x-filament::section>
        </div>

        {{-- ================================================================= --}}
        {{-- BARRA DE GUARDADO --}}
        {{-- ================================================================= --}}
        <div class="p-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm flex items-center justify-between gap-4">
            <span class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1.5">
                <x-filament::icon icon="heroicon-m-shield-check" class="w-4 h-4 text-emerald-500" />
                Los cambios se aplican de forma inmediata en el portal público y regeneran el caché de configuración.
            </span>
            <x-filament::button type="submit" size="lg" icon="heroicon-m-check">
                Guardar Configuración
            </x-filament::button>
        </div>

    </form>
</x-filament-panels::page>
