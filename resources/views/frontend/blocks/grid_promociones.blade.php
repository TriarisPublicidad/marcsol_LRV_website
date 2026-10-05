@php
    $limite = (int) ($data['limite'] ?? 6);
    $soloDestacadas = (bool) ($data['solo_destacadas'] ?? false);
    $promosCollection = isset($promociones) ? $promociones : \App\Models\Promotion::active()->with(['category', 'branch'])->latest()->take($limite)->get();
    $promosFiltradas = $soloDestacadas
        ? $promosCollection->where('es_promocion_del_dia', true)->take($limite)
        : $promosCollection->take($limite);
@endphp
<section class="py-16 bg-gray-50 border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-end mb-10 gap-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-marcsol-secondary">Ahorro Insuperable</span>
                <h2 class="text-3xl font-black text-gray-900 tracking-tight mt-1">
                    {{ $data['titulo'] ?? 'Nuestras Ofertas Destacadas' }}
                </h2>
                @if(!empty($data['subtitulo']))
                    <p class="text-sm text-gray-500 mt-1">{{ $data['subtitulo'] }}</p>
                @endif
            </div>
            <a href="{{ url('/promociones') }}" class="text-sm font-bold text-marcsol-primary hover:underline flex items-center gap-1">
                Ver todas las promociones
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($promosFiltradas as $promo)
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl border border-gray-100 transition-all flex flex-col group">
                    <div class="relative h-48 bg-gray-100 overflow-hidden">
                        @if($promo->imagen)
                            <img src="{{ asset('storage/' . $promo->imagen) }}" alt="{{ $promo->titulo }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-blue-50 text-marcsol-primary">
                                <svg class="w-12 h-12 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                            </div>
                        @endif

                        @if($promo->es_promocion_del_dia)
                            <span class="absolute top-3 left-3 bg-red-600 text-white text-[10px] font-black uppercase tracking-wider px-2.5 py-1 rounded-md shadow">
                                Promo del Día
                            </span>
                        @endif

                        @if($promo->category)
                            <span class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm text-gray-800 text-[10px] font-bold px-2 py-0.5 rounded-md shadow-sm">
                                {{ $promo->category->nombre }}
                            </span>
                        @endif
                    </div>

                    <div class="p-6 flex-grow flex flex-col justify-between space-y-4">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 group-hover:text-marcsol-primary transition-colors">
                                <a href="{{ url('/promociones/' . $promo->slug) }}">
                                    {{ $promo->titulo }}
                                </a>
                            </h3>
                            <p class="text-xs text-gray-500 mt-2 line-clamp-2 leading-relaxed">
                                {{ $promo->descripcion }}
                            </p>
                        </div>

                        <div class="pt-4 border-t border-gray-100 flex items-center justify-between text-xs">
                            <span class="text-gray-400">
                                📍 {{ $promo->branch ? $promo->branch->nombre : 'Todas las sucursales' }}
                            </span>
                            <a href="{{ url('/promociones/' . $promo->slug) }}" class="font-bold text-marcsol-primary group-hover:underline">
                                Ver Detalle
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12 text-gray-500">
                    No hay promociones disponibles en este momento.
                </div>
            @endforelse
        </div>
    </div>
</section>
