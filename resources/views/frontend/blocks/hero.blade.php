<section class="relative bg-gradient-to-br from-slate-900 via-blue-950 to-slate-900 text-white overflow-hidden py-16 lg:py-24"
    @if(!empty($data['imagen_fondo'])) style="background-image: linear-gradient(rgba(15, 23, 42, 0.85), rgba(15, 23, 42, 0.85)), url('{{ asset('storage/' . $data['imagen_fondo']) }}'); background-size: cover; background-position: center;" @endif
>
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#F58220_1px,transparent_1px)] [background-size:16px_16px]"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 backdrop-blur-md text-amber-300 text-xs font-semibold uppercase tracking-wider">
                    <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                    Calidad y Economía en Quevedo
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight leading-tight">
                    {{ $data['titulo'] ?? 'Gran Variedad y Precios Bajos en Quevedo' }}
                </h1>

                @if(!empty($data['subtitulo']))
                    <p class="text-lg text-slate-300 max-w-2xl mx-auto lg:mx-0 font-light leading-relaxed">
                        {{ $data['subtitulo'] }}
                    </p>
                @endif

                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start pt-2">
                    <a href="{{ $data['boton_url'] ?? url('/promociones') }}" class="px-8 py-3.5 rounded-xl font-bold bg-marcsol-secondary hover:brightness-110 text-white shadow-lg transition-all flex items-center justify-center gap-2">
                        <span>{{ $data['boton_texto'] ?? 'Explorar Ofertas' }}</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                    <a href="{{ url('/sucursales') }}" class="px-8 py-3.5 rounded-xl font-semibold bg-white/10 hover:bg-white/20 text-white backdrop-blur-md transition-all flex items-center justify-center gap-2">
                        <span>Nuestras Sucursales</span>
                    </a>
                </div>
            </div>

            <div class="lg:col-span-5">
                @if(isset($promoDelDia) && $promoDelDia)
                    <div class="relative group">
                        <div class="absolute -inset-1 bg-gradient-to-r from-marcsol-secondary to-amber-500 rounded-3xl blur opacity-30 group-hover:opacity-60 transition duration-500"></div>
                        <div class="relative rounded-3xl bg-slate-900/90 border border-white/10 p-6 sm:p-8 backdrop-blur-xl shadow-2xl space-y-6">
                            <div class="flex items-center justify-between">
                                <span class="px-3 py-1 rounded-full bg-red-600 text-white text-xs font-black uppercase tracking-wider animate-bounce">
                                    ¡Oferta del Día!
                                </span>
                                <span class="text-xs text-amber-300 font-medium">Hasta agotar stock</span>
                            </div>

                            @if($promoDelDia->imagen)
                                <div class="h-48 rounded-xl overflow-hidden bg-gray-800">
                                    <img src="{{ asset('storage/' . $promoDelDia->imagen) }}" alt="{{ $promoDelDia->titulo }}" class="w-full h-full object-cover">
                                </div>
                            @endif

                            <div>
                                <h3 class="text-2xl font-bold text-white leading-snug">
                                    {{ $promoDelDia->titulo }}
                                </h3>
                                <p class="text-sm text-gray-300 mt-2 line-clamp-2">
                                    {{ $promoDelDia->descripcion }}
                                </p>
                            </div>

                            <div class="pt-4 border-t border-gray-800 flex items-center justify-between text-xs text-gray-400">
                                <span>Válido hoy en Quevedo</span>
                                <a href="{{ url('/promociones/' . $promoDelDia->slug) }}" class="font-bold text-amber-400 hover:text-amber-300 flex items-center gap-1">
                                    Ver Detalle →
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="rounded-3xl bg-white/5 border border-white/10 p-8 text-center space-y-4 backdrop-blur-md">
                        <span class="text-4xl">🛒</span>
                        <h3 class="text-xl font-bold text-white">Super Descuentos en Sucursales</h3>
                        <p class="text-sm text-gray-300">Descubre nuestros combos corporativos y canastas de ahorro todos los días.</p>
                        <a href="{{ url('/promociones') }}" class="inline-block px-6 py-2.5 rounded-xl text-sm font-bold bg-marcsol-secondary text-white">Ver Catálogo</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
