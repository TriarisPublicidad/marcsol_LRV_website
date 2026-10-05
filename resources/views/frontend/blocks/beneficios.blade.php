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
                <div class="w-12 h-12 rounded-xl bg-blue-100 text-marcsol-primary flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                    🥩
                </div>
                <h3 class="font-bold text-gray-900 text-base">Frescura Garantizada</h3>
                <p class="text-xs text-gray-500 leading-relaxed">
                    Carnes y legumbres con cadena de frío ininterrumpida y selección rigurosa diaria.
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-gray-50 border border-gray-100 space-y-3 hover:shadow-lg transition-all group">
                <div class="w-12 h-12 rounded-xl bg-amber-100 text-marcsol-secondary flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                    🏷️
                </div>
                <h3 class="font-bold text-gray-900 text-base">Precios Mayoristas</h3>
                <p class="text-xs text-gray-500 leading-relaxed">
                    Descuentos escalonados por volumen para negocios, restaurantes y familias de Quevedo.
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-gray-50 border border-gray-100 space-y-3 hover:shadow-lg transition-all group">
                <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                    ⚖️
                </div>
                <h3 class="font-bold text-gray-900 text-base">Peso y Precio Justo</h3>
                <p class="text-xs text-gray-500 leading-relaxed">
                    Balanzas electrónicas certificadas y facturación detallada sin costos ocultos.
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-gray-50 border border-gray-100 space-y-3 hover:shadow-lg transition-all group">
                <div class="w-12 h-12 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                    🤝
                </div>
                <h3 class="font-bold text-gray-900 text-base">Crédito Empresarial</h3>
                <p class="text-xs text-gray-500 leading-relaxed">
                    Facilidades de pago y cuentas corporativas con entrega programada a tu negocio.
                </p>
            </div>
        </div>
    </div>
</section>
