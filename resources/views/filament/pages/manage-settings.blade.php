<x-filament-panels::page>
    <form wire:submit="save" class="space-y-6">
        <!-- NavegaciÃ³n por PestaÃ±as -->
        <div class="border-b border-gray-200 dark:border-gray-700">
            <nav class="-mb-px flex space-x-6" aria-label="Tabs">
                <button type="button" wire:click="$set('activeTab', 'branding')"
                    class="py-3 px-1 border-b-2 font-medium text-sm transition-colors {{ $activeTab === 'branding' ? 'border-primary-500 text-primary-600 dark:text-primary-400' : 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400' }}">
                    ðŸŽ¨ Identidad & Branding
                </button>
                <button type="button" wire:click="$set('activeTab', 'tracking')"
                    class="py-3 px-1 border-b-2 font-medium text-sm transition-colors {{ $activeTab === 'tracking' ? 'border-primary-500 text-primary-600 dark:text-primary-400' : 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400' }}">
                    ðŸ“Š Data Tracking & Pixels
                </button>
                <button type="button" wire:click="$set('activeTab', 'seo')"
                    class="py-3 px-1 border-b-2 font-medium text-sm transition-colors {{ $activeTab === 'seo' ? 'border-primary-500 text-primary-600 dark:text-primary-400' : 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400' }}">
                    ðŸ” SEO Global & Schema.org
                </button>
            </nav>
        </div>

        <!-- PestaÃ±a 1: Branding -->
        <div x-show="$wire.activeTab === 'branding'" class="space-y-6">
            <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 space-y-4">
                <h3 class="text-base font-semibold text-gray-900 dark:text-white">Identidad de Marca y Colores Corporativos</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">Estos colores se inyectan automÃ¡ticamente en la hoja de estilos global como variables CSS (:root).</p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre Comercial</label>
                        <input type="text" wire:model="site_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Eslogan Corporativo</label>
                        <input type="text" wire:model="site_tagline" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">TelÃ©fono Central</label>
                        <input type="text" wire:model="company_phone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white text-sm">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Color Primario (HEX)</label>
                        <div class="flex items-center space-x-2 mt-1">
                            <input type="color" wire:model.live="primary_color" class="h-9 w-12 rounded cursor-pointer border-0">
                            <input type="text" wire:model="primary_color" class="block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white text-sm font-mono">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Color Secundario (HEX)</label>
                        <div class="flex items-center space-x-2 mt-1">
                            <input type="color" wire:model.live="secondary_color" class="h-9 w-12 rounded cursor-pointer border-0">
                            <input type="text" wire:model="secondary_color" class="block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white text-sm font-mono">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Color de Acento / Ã‰xito (HEX)</label>
                        <div class="flex items-center space-x-2 mt-1">
                            <input type="color" wire:model.live="accent_color" class="h-9 w-12 rounded cursor-pointer border-0">
                            <input type="text" wire:model="accent_color" class="block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white text-sm font-mono">
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">WhatsApp de AtenciÃ³n</label>
                        <input type="text" wire:model="company_whatsapp" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Correo ElectrÃ³nico de Contacto</label>
                        <input type="email" wire:model="company_email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white text-sm">
                    </div>
                    <div class="md:column-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">DirecciÃ³n Principal en Quevedo</label>
                        <input type="text" wire:model="company_address" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white text-sm">
                    </div>
                </div>
            </div>
        </div>

        <!-- PestaÃ±a 2: Data Tracking -->
        <div x-show="$wire.activeTab === 'tracking'" class="space-y-6">
            <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 space-y-4">
                <h3 class="text-base font-semibold text-gray-900 dark:text-white">Identificadores de AnalÃ­tica y PÃ­xeles</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">Ingresa Ãºnicamente los IDs correspondientes. Las etiquetas se inyectan sanitizadas de forma segura.</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Google Tag Manager ID</label>
                        <input type="text" wire:model="gtm_id" placeholder="GTM-XXXXXXX" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white text-sm font-mono">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Meta (Facebook) Pixel ID</label>
                        <input type="text" wire:model="meta_pixel_id" placeholder="123456789012345" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white text-sm font-mono">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">TikTok Pixel ID</label>
                        <input type="text" wire:model="tiktok_pixel_id" placeholder="CXXXXXX..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white text-sm font-mono">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Microsoft Clarity ID</label>
                        <input type="text" wire:model="clarity_id" placeholder="xxxxxxx" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white text-sm font-mono">
                    </div>
                </div>

                <div class="space-y-4 pt-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Scripts Personalizados en &lt;head&gt;</label>
                        <textarea wire:model="custom_head_scripts" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white text-xs font-mono" placeholder="<!-- Meta tags o scripts adicionales de verificaciÃ³n -->"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Scripts Personalizados en el cierre de &lt;body&gt;</label>
                        <textarea wire:model="custom_body_scripts" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white text-xs font-mono" placeholder="<!-- CÃ³digos de conversiÃ³n o widgets -->"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- PestaÃ±a 3: SEO Global -->
        <div x-show="$wire.activeTab === 'seo'" class="space-y-6">
            <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 space-y-4">
                <h3 class="text-base font-semibold text-gray-900 dark:text-white">Metadatos Globales y Estructura Schema.org</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">Valores predeterminados aplicados a pÃ¡ginas sin metadatos especÃ­ficos.</p>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Meta TÃ­tulo Predeterminado</label>
                        <input type="text" wire:model="meta_title_default" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Meta DescripciÃ³n Predeterminada</label>
                        <textarea wire:model="meta_description_default" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white text-sm"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipo de Negocio Schema.org</label>
                        <select wire:model="schema_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white text-sm">
                            <option value="Supermarket">Supermarket (Supermercado)</option>
                            <option value="GroceryStore">GroceryStore (Tienda de Abarrotes)</option>
                            <option value="LocalBusiness">LocalBusiness (Negocio Local)</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- BotÃ³n Guardar -->
        <div class="flex justify-end pt-4">
            <x-filament::button type="submit" size="lg" icon="heroicon-m-check">
                Guardar Cambios
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
