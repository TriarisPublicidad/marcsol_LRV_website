@extends('layouts.app')

@section('meta_title', 'Marcsol Supermercado Corporativo | Quevedo - Ecuador')
@section('meta_description', 'Encuentra las mejores ofertas del día, carnes frescas, víveres y productos para tu hogar y empresa en Marcsol Quevedo.')

@section('content')
<!-- Hero Section con Promoción Destacada / Carrusel -->
<section class="relative bg-gradient-to-br from-slate-900 via-blue-950 to-slate-900 text-white overflow-hidden py-16 lg:py-24" x-data="{ currentSlide: 0, totalSlides: {{ $promociones->count() > 0 ? $promociones->count() : 1 }} }">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#F58220_1px,transparent_1px)] [background-size:16px_16px]"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <!-- Textos y Llamado a la Acción -->
            <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 backdrop-blur-md text-amber-300 text-xs font-semibold uppercase tracking-wider">
                    <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                    Calidad y Economía en Quevedo
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight leading-tight">
                    Tu Ahorro Diario en <span class="text-marcsol-secondary">Marcsol</span>
                </h1>

                <p class="text-lg text-slate-300 max-w-2xl mx-auto lg:mx-0 font-light leading-relaxed">
                    Alimentos frescos, carnes seleccionadas, abarrotes y precios especiales para familias y empresas. ¡Visita nuestras 3 sucursales en Quevedo!
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start pt-2">
                    <a href="{{ url('/promociones') }}" class="px-8 py-3.5 rounded-xl font-bold bg-marcsol-secondary hover:brightness-110 text-white shadow-lg shadow-orange-500/30 transition-all flex items-center justify-center gap-2">
                        <span>Explorar Ofertas</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                    <a href="{{ url('/sucursales') }}" class="px-8 py-3.5 rounded-xl font-semibold bg-white/10 hover:bg-white/20 text-white backdrop-blur-md transition-all flex items-center justify-center gap-2">
                        <span>Nuestras Sucursales</span>
                    </a>
                </div>
            </div>

            <!-- Banner o Tarjeta de la Promoción del Día -->
            <div class="lg:col-span-5" x-intersect="$el.classList.add('opacity-100', 'translate-y-0')">
                @if($promoDelDia)
                    <div class="relative rounded-3xl p-1 bg-gradient-to-tr from-amber-400 to-orange-500 shadow-2xl transition-transform hover:-translate-y-1">
                        <div class="bg-gray-900 rounded-[22px] p-6 text-white space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider bg-red-600 text-white">
                                    🔥 Promoción del Día
                                </span>
                                @if($promoDelDia->category)
                                    <span class="text-xs text-amber-300 font-semibold">
                                        {{ $promoDelDia->category->nombre }}
                                    </span>
                                @endif
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
                                <p class="text-sm text-gray-300 mt-2 line-clamp-3">
                                    {{ $promoDelDia->descripcion }}
                                </p>
                            </div>

                            <div class="pt-4 border-t border-gray-800 flex items-center justify-between text-xs text-gray-400">
                                <span>Válido hoy hasta las 21:30</span>
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

<!-- Categorías Destacadas -->
<section class="py-12 bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-8">
            <h2 class="text-2xl font-black text-gray-900 tracking-tight">Variedad en Todas las Secciones</h2>
            <p class="text-sm text-gray-500 mt-1">Explora nuestras categorías de productos seleccionados con calidad garantizada.</p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($categorias as $cat)
                <a href="{{ url('/promociones?categoria=' . $cat->slug) }}" class="group p-4 rounded-2xl bg-gray-50 hover:bg-blue-50/60 border border-gray-100 hover:border-blue-200 transition-all text-center flex flex-col items-center justify-center">
                    <div class="w-12 h-12 rounded-xl bg-white shadow-sm flex items-center justify-center text-marcsol-primary group-hover:scale-110 transition-transform mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    </div>
                    <span class="text-xs font-bold text-gray-800 group-hover:text-marcsol-primary">{{ $cat->nombre }}</span>
                    <span class="text-[10px] text-gray-400 mt-1">{{ $cat->promotions_count }} ofertas</span>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Grid de Promociones Principales -->
<section class="py-16 bg-gray-50" x-intersect="$el.classList.add('opacity-100')">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-end mb-10 gap-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-marcsol-secondary">Ahorro Garantizado</span>
                <h2 class="text-3xl font-black text-gray-900 tracking-tight mt-1">Promociones Destacadas</h2>
            </div>
            <a href="{{ url('/promociones') }}" class="text-sm font-bold text-marcsol-primary hover:underline flex items-center gap-1">
                Ver todas las promociones
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($promociones as $promo)
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
                    No hay promociones activas en este momento.
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Próximos Eventos y Activaciones -->
@if($eventos->count() > 0)
<section class="py-16 bg-white border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-end mb-10 gap-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-marcsol-secondary">Vida y Comunidad</span>
                <h2 class="text-3xl font-black text-gray-900 tracking-tight mt-1">Próximos Eventos en Quevedo</h2>
            </div>
            <a href="{{ url('/eventos') }}" class="text-sm font-bold text-marcsol-primary hover:underline flex items-center gap-1">
                Ver todos los eventos
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($eventos as $evento)
                <div class="rounded-2xl border border-gray-200 overflow-hidden p-6 hover:border-marcsol-primary transition-all flex flex-col justify-between space-y-4">
                    <div class="space-y-3">
                        <div class="flex items-center gap-2 text-xs font-semibold text-marcsol-secondary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            {{ $evento->fecha_evento->format('d/m/Y - H:i') }}
                        </div>

                        <h3 class="text-lg font-bold text-gray-900 hover:text-marcsol-primary">
                            <a href="{{ url('/eventos/' . $evento->slug) }}">
                                {{ $evento->titulo }}
                            </a>
                        </h3>

                        <p class="text-xs text-gray-500 line-clamp-3">
                            {{ $evento->descripcion }}
                        </p>
                    </div>

                    <div class="pt-4 border-t border-gray-100 flex items-center justify-between text-xs">
                        <span class="text-gray-400 truncate max-w-[180px]">
                            📍 {{ $evento->lugar }}
                        </span>
                        <a href="{{ url('/eventos/' . $evento->slug) }}" class="font-bold text-marcsol-primary hover:underline">
                            Más info →
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Sucursales en Quevedo -->
<section class="py-16 bg-gray-50 border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-xs font-bold uppercase tracking-wider text-marcsol-secondary">Cerca de Ti</span>
            <h2 class="text-3xl font-black text-gray-900 tracking-tight mt-1">Nuestras Sucursales en Quevedo</h2>
            <p class="text-sm text-gray-500 mt-2">Visítanos en cualquiera de nuestros 3 puntos estratégicos en la ciudad.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($sucursales as $sucursal)
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-900">{{ $sucursal->nombre }}</h3>
                        <span class="px-2 py-0.5 text-[10px] font-bold uppercase bg-emerald-100 text-emerald-700 rounded">Abierto</span>
                    </div>

                    <p class="text-xs text-gray-500 leading-relaxed">
                        📍 {{ $sucursal->direccion }}
                    </p>

                    <div class="text-xs text-gray-600 bg-gray-50 p-3 rounded-xl space-y-1">
                        <p class="font-medium text-gray-700">🕒 Horario:</p>
                        <p>{{ $sucursal->horarios ?? '07:30 a 21:00' }}</p>
                    </div>

                    <div class="pt-2 flex items-center justify-between">
                        @if($sucursal->telefono)
                            <a href="tel:{{ $sucursal->telefono }}" class="text-xs font-semibold text-gray-700 hover:text-marcsol-primary">
                                📞 {{ $sucursal->telefono }}
                            </a>
                        @endif
                        <a href="{{ url('/sucursales/' . $sucursal->slug) }}" class="text-xs font-bold text-marcsol-primary hover:underline">
                            Ver Mapa y Ficha →
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
