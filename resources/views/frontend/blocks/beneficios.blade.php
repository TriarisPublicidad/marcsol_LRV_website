<section class="py-16 bg-white border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-xs font-bold uppercase tracking-wider text-marcsol-secondary">¿Por qué elegirnos?</span>
            <h2 class="text-3xl font-black text-gray-900 tracking-tight mt-1">
                {{ $data['titulo'] ?? 'Ventajas Corporativas Marcsol' }}
            </h2>
            @if(!empty($data['subtitulo']))
                <p class="text-sm text-gray-500 mt-2">{{ $data['subtitulo'] }}</p>
            @endif
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="p-6 rounded-2xl bg-gray-50 border border-gray-100 space-y-3 hover:shadow-lg transition-all group">
                <div class="w-12 h-12 rounded-xl bg-blue-100 text-marcsol-primary flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <h3 class="font-bold text-gray-900 text-base">Frescura Garantizada</h3>
                <p class="text-xs text-gray-500 leading-relaxed">
                    Carnes y legumbres con cadena de frío ininterrumpida y selección rigurosa diaria.
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-gray-50 border border-gray-100 space-y-3 hover:shadow-lg transition-all group">
                <div class="w-12 h-12 rounded-xl bg-amber-100 text-marcsol-secondary flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                </div>
                <h3 class="font-bold text-gray-900 text-base">Precios Mayoristas</h3>
                <p class="text-xs text-gray-500 leading-relaxed">
                    Descuentos escalonados por volumen para negocios, restaurantes y familias de Quevedo.
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-gray-50 border border-gray-100 space-y-3 hover:shadow-lg transition-all group">
                <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/></svg>
                </div>
                <h3 class="font-bold text-gray-900 text-base">Peso y Precio Justo</h3>
                <p class="text-xs text-gray-500 leading-relaxed">
                    Balanzas electrónicas certificadas y facturación detallada sin costos ocultos.
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-gray-50 border border-gray-100 space-y-3 hover:shadow-lg transition-all group">
                <div class="w-12 h-12 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <h3 class="font-bold text-gray-900 text-base">Crédito Empresarial</h3>
                <p class="text-xs text-gray-500 leading-relaxed">
                    Facilidades de pago y cuentas corporativas con entrega programada a tu negocio.
                </p>
            </div>
        </div>
    </div>
</section>
