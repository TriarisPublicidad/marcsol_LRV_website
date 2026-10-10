@if(isset($promoDelDia) && $promoDelDia)
    <section class="py-12 bg-amber-500/10 border-y border-amber-500/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-r from-slate-900 to-blue-950 rounded-3xl p-8 lg:p-12 text-white shadow-xl flex flex-col lg:flex-row items-center justify-between gap-8">
                <div class="space-y-4 max-w-2xl text-center lg:text-left">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-red-600 text-white text-xs font-black uppercase rounded-full tracking-wider">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/></svg>
                        <span>{{ str_replace('🔥 ', '', $data['titulo'] ?? 'Promoción del Día') }}</span>
                    </div>
                    <h3 class="text-3xl lg:text-4xl font-black">{{ $promoDelDia->titulo }}</h3>
                    <p class="text-gray-300 text-sm leading-relaxed">{{ $promoDelDia->descripcion }}</p>
                    <p class="text-xs text-amber-400 font-semibold flex items-center gap-1.5 justify-center lg:justify-start">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>Disponible en: {{ $promoDelDia->branch->nombre ?? 'Todas las sucursales' }}</span>
                    </p>
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
