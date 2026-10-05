@if(isset($promoDelDia) && $promoDelDia)
    <section class="py-12 bg-amber-500/10 border-y border-amber-500/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-r from-slate-900 to-blue-950 rounded-3xl p-8 lg:p-12 text-white shadow-xl flex flex-col lg:flex-row items-center justify-between gap-8">
                <div class="space-y-4 max-w-2xl text-center lg:text-left">
                    <span class="inline-block px-3 py-1 bg-red-600 text-white text-xs font-black uppercase rounded-full tracking-wider">
                        {{ $data['titulo'] ?? '🔥 Promoción del Día' }}
                    </span>
                    <h3 class="text-3xl lg:text-4xl font-black">{{ $promoDelDia->titulo }}</h3>
                    <p class="text-gray-300 text-sm leading-relaxed">{{ $promoDelDia->descripcion }}</p>
                    <p class="text-xs text-amber-400 font-semibold">📍 Disponible en: {{ $promoDelDia->branch->nombre ?? 'Todas las sucursales' }}</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-4 items-center flex-shrink-0">
                    <a href="{{ url('/promociones/' . $promoDelDia->slug) }}" class="px-8 py-3.5 rounded-xl font-bold bg-marcsol-secondary hover:brightness-110 text-white shadow-lg transition">
                        Aprovechar Oferta →
                    </a>
                </div>
            </div>
        </div>
    </section>
@endif
