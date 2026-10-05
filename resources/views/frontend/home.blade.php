@extends('layouts.app')

@section('meta_title', ($page && $page->meta_title) ? $page->meta_title : 'Marcsol Supermercado Corporativo | Quevedo - Ecuador')
@section('meta_description', ($page && $page->meta_description) ? $page->meta_description : 'Encuentra las mejores ofertas del día, carnes frescas, víveres y productos para tu hogar y empresa en Marcsol Quevedo.')

@section('content')
@if($page && is_array($page->contenido_json_bloques) && count($page->contenido_json_bloques) > 0)
    {{-- ================================================================= --}}
    {{-- PORTADA MODULAR DINÁMICA GOBERNADA POR FILAMENT PAGEBUILDER       --}}
    {{-- ================================================================= --}}
    @foreach($page->contenido_json_bloques as $bloque)
        @php
            $type = $bloque['type'] ?? '';
            $data = $bloque['data'] ?? [];
        @endphp

        @switch($type)

            {{-- 1. BLOQUE HERO / CABECERA --}}
            @case('hero')
                <section class="relative bg-gradient-to-br from-slate-900 via-blue-950 to-slate-900 text-white overflow-hidden py-16 lg:py-24"
                    @if(!empty($data['imagen_fondo'])) style="background-image: linear-gradient(rgba(15, 23, 42, 0.85), rgba(15, 23, 42, 0.85)), url('{{ asset('storage/' . $data['imagen_fondo']) }}'); background-size: cover; background-position: center;" @endif>
                    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#F58220_1px,transparent_1px)] [background-size:16px_16px]"></div>

                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                            <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 backdrop-blur-md text-amber-300 text-xs font-semibold uppercase tracking-wider">
                                    <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                                    Calidad y Economía en Quevedo
                                </div>

                                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight leading-tight">
                                    {{ $data['titulo'] ?? 'Tu Ahorro Diario en Marcsol' }}
                                </h1>

                                @if(!empty($data['subtitulo']))
                                    <p class="text-lg text-slate-300 max-w-2xl mx-auto lg:mx-0 font-light leading-relaxed">
                                        {{ $data['subtitulo'] }}
                                    </p>
                                @endif

                                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start pt-2">
                                    @if(!empty($data['boton_texto']))
                                        <a href="{{ url($data['boton_url'] ?? '/promociones') }}" class="px-8 py-3.5 rounded-xl font-bold bg-marcsol-secondary hover:brightness-110 text-white shadow-lg shadow-orange-500/30 transition-all flex items-center justify-center gap-2">
                                            <span>{{ $data['boton_texto'] }}</span>
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                        </a>
                                    @endif
                                    <a href="{{ url('/sucursales') }}" class="px-8 py-3.5 rounded-xl font-semibold bg-white/10 hover:bg-white/20 text-white backdrop-blur-md transition-all flex items-center justify-center gap-2">
                                        <span>Nuestras Sucursales</span>
                                    </a>
                                </div>
                            </div>

                            {{-- Columna derecha: Tarjeta de Promoción del Día o Banner --}}
                            <div class="lg:col-span-5">
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
                @break

            {{-- 2. BLOQUE PROMOCIÓN DEL DÍA EXCLUSIVO --}}
            @case('promocion_del_dia')
                @if($promoDelDia)
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
                @break

            {{-- 3. BLOQUE GRID DE PROMOCIONES --}}
            @case('grid_promociones')
                @php
                    $limite = (int) ($data['limite'] ?? 6);
                    $soloDestacadas = (bool) ($data['solo_destacadas'] ?? false);
                    $promosFiltradas = $soloDestacadas
                        ? $promociones->where('es_promocion_del_dia', true)->take($limite)
                        : $promociones->take($limite);
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
                @break

            {{-- 4. BLOQUE NOTICIAS / EVENTOS Y ACTIVACIONES --}}
            @case('eventos')
                @php
                    $limiteEventos = (int) ($data['limite'] ?? 3);
                    $eventosMostrar = $eventos->take($limiteEventos);
                @endphp
                <section class="py-16 bg-white border-t border-gray-100">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="flex flex-col md:flex-row justify-between items-end mb-10 gap-4">
                            <div>
                                <span class="text-xs font-bold uppercase tracking-wider text-marcsol-secondary">Vida y Comunidad</span>
                                <h2 class="text-3xl font-black text-gray-900 tracking-tight mt-1">
                                    {{ $data['titulo'] ?? 'Próximos Eventos y Noticias en Quevedo' }}
                                </h2>
                                @if(!empty($data['subtitulo']))
                                    <p class="text-sm text-gray-500 mt-1">{{ $data['subtitulo'] }}</p>
                                @endif
                            </div>
                            <a href="{{ url('/eventos') }}" class="text-sm font-bold text-marcsol-primary hover:underline flex items-center gap-1">
                                Ver todos los eventos
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            @forelse($eventosMostrar as $evento)
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
                            @empty
                                <div class="col-span-3 text-center py-12 text-gray-500">
                                    No hay eventos programados en este momento.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </section>
                @break

            {{-- 5. BLOQUE CATEGORÍAS / DEPARTAMENTOS --}}
            @case('categorias')
                <section class="py-12 bg-white border-b border-gray-100">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="text-center max-w-2xl mx-auto mb-8">
                            <h2 class="text-2xl font-black text-gray-900 tracking-tight">
                                {{ $data['titulo'] ?? 'Variedad en Todas las Secciones' }}
                            </h2>
                            @if(!empty($data['subtitulo']))
                                <p class="text-sm text-gray-500 mt-1">{{ $data['subtitulo'] }}</p>
                            @endif
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                            @foreach($categorias as $cat)
                                <a href="{{ url('/promociones?categoria=' . $cat->slug) }}" class="p-4 rounded-2xl bg-gray-50 hover:bg-amber-50 border border-gray-100 hover:border-amber-200 transition-all text-center space-y-2 group">
                                    <div class="w-12 h-12 mx-auto rounded-full bg-white shadow-sm flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                                        @switch($cat->slug)
                                            @case('carnes-y-embutidos') 🥩 @break
                                            @case('lacteos-y-huevos') 🧀 @break
                                            @case('frutas-y-verduras') 🥦 @break
                                            @case('abarrotes-y-despensa') 🍚 @break
                                            @case('bebidas-y-licores') 🥤 @break
                                            @case('limpieza-y-hogar') 🧼 @break
                                            @default 🛒
                                        @endswitch
                                    </div>
                                    <h4 class="text-xs font-bold text-gray-800 group-hover:text-marcsol-primary">{{ $cat->nombre }}</h4>
                                    <span class="text-[10px] text-gray-400 block">{{ $cat->promotions_count }} ofertas</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </section>
                @break

            {{-- 6. BLOQUE SUCURSALES EN QUEVEDO --}}
            @case('sucursales')
                <section class="py-16 bg-gray-50 border-t border-gray-100">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="text-center max-w-2xl mx-auto mb-12">
                            <span class="text-xs font-bold uppercase tracking-wider text-marcsol-secondary">Cerca de Ti</span>
                            <h2 class="text-3xl font-black text-gray-900 tracking-tight mt-1">
                                {{ $data['titulo'] ?? 'Nuestras Sucursales en Quevedo' }}
                            </h2>
                            @if(!empty($data['subtitulo']))
                                <p class="text-sm text-gray-500 mt-2">{{ $data['subtitulo'] }}</p>
                            @endif
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
                @break

            {{-- 7. BLOQUE TEXTO CON IMAGEN --}}
            @case('texto_imagen')
                <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                        @php $pos = $data['posicion_imagen'] ?? 'derecha'; @endphp
                        <div class="lg:col-span-7 space-y-6 {{ $pos === 'izquierda' ? 'lg:order-2' : '' }}">
                            <h2 class="text-3xl font-black text-gray-900 tracking-tight">{{ $data['titulo'] ?? '' }}</h2>
                            <div class="prose prose-base text-gray-600 leading-relaxed">
                                {!! nl2br(e($data['contenido'] ?? '')) !!}
                            </div>
                        </div>
                        <div class="lg:col-span-5 {{ $pos === 'izquierda' ? 'lg:order-1' : '' }}">
                            @if(!empty($data['imagen']))
                                <img src="{{ asset('storage/' . $data['imagen']) }}" alt="{{ $data['titulo'] ?? '' }}" class="rounded-3xl shadow-xl w-full object-cover">
                            @else
                                <div class="h-64 rounded-3xl bg-blue-50 border border-blue-100 flex items-center justify-center text-marcsol-primary">
                                    <svg class="w-16 h-16 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif
                        </div>
                    </div>
                </section>
                @break

            {{-- 8. BLOQUE BENEFICIOS CORPORATIVOS --}}
            @case('beneficios')
                <section class="py-16 bg-white border-t border-gray-100">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                        <h2 class="text-2xl font-black text-gray-900 tracking-tight">{{ $data['titulo'] ?? '¿Por qué comprar en Marcsol?' }}</h2>
                        @if(!empty($data['subtitulo']))
                            <p class="text-sm text-gray-500 mt-2 max-w-xl mx-auto">{{ $data['subtitulo'] }}</p>
                        @endif

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 mt-12">
                            <div class="p-6 rounded-2xl bg-gray-50 space-y-3">
                                <span class="text-3xl">🥦</span>
                                <h4 class="font-bold text-gray-900 text-sm">Frescura Garantizada</h4>
                                <p class="text-xs text-gray-500">Frutas, legumbres y carnes seleccionadas diariamente de productores locales de Los Ríos.</p>
                            </div>
                            <div class="p-6 rounded-2xl bg-gray-50 space-y-3">
                                <span class="text-3xl">💰</span>
                                <h4 class="font-bold text-gray-900 text-sm">Precios de Mayorista</h4>
                                <p class="text-xs text-gray-500">Ahorro real en canasta básica y tarifas corporativas para negocios y hoteles.</p>
                            </div>
                            <div class="p-6 rounded-2xl bg-gray-50 space-y-3">
                                <span class="text-3xl">💳</span>
                                <h4 class="font-bold text-gray-900 text-sm">Todas las Formas de Pago</h4>
                                <p class="text-xs text-gray-500">Efectivo, tarjetas de débito/crédito, transferencias y pagos con Deuna sin recargos.</p>
                            </div>
                            <div class="p-6 rounded-2xl bg-gray-50 space-y-3">
                                <span class="text-3xl">🛡️</span>
                                <h4 class="font-bold text-gray-900 text-sm">Cadena de Frío Segura</h4>
                                <p class="text-xs text-gray-500">Cámaras frigoríficas de última tecnología que garantizan la inocuidad alimentaria.</p>
                            </div>
                        </div>
                    </div>
                </section>
                @break

            {{-- 9. BLOQUE FAQS --}}
            @case('faqs')
                <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16" x-data="{ openFaq: null }">
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-black text-gray-900 tracking-tight">
                            {{ $data['titulo'] ?? 'Preguntas Frecuentes' }}
                        </h2>
                    </div>

                    @if(!empty($data['items']) && is_array($data['items']))
                        <div class="space-y-4">
                            @foreach($data['items'] as $index => $item)
                                <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm">
                                    <button type="button" @click="openFaq = (openFaq === {{ $index }} ? null : {{ $index }})"
                                        class="w-full p-5 text-left font-bold text-gray-900 flex justify-between items-center hover:bg-gray-50 transition-colors">
                                        <span>{{ $item['pregunta'] ?? '' }}</span>
                                        <svg class="w-5 h-5 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': openFaq === {{ $index }} }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    </button>
                                    <div x-show="openFaq === {{ $index }}" x-collapse class="px-5 pb-5 text-sm text-gray-600 border-t border-gray-100 pt-3 leading-relaxed">
                                        {{ $item['respuesta'] ?? '' }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </section>
                @break

            {{-- 10. BLOQUE BANNER CALL TO ACTION --}}
            @case('banner_cta')
                <section class="py-12 bg-gray-900 text-white">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
                        <h3 class="text-3xl font-black">{{ $data['titulo'] ?? '' }}</h3>
                        @if(!empty($data['subtitulo']))
                            <p class="text-gray-300 text-sm max-w-xl mx-auto">{{ $data['subtitulo'] }}</p>
                        @endif
                        @if(!empty($data['boton_texto']))
                            <div class="pt-2">
                                <a href="{{ url($data['boton_url'] ?? '/contacto') }}" class="inline-block px-8 py-3.5 rounded-xl font-bold bg-marcsol-secondary hover:brightness-110 text-white shadow-lg transition">
                                    {{ $data['boton_texto'] }}
                                </a>
                            </div>
                        @endif
                    </div>
                </section>
                @break

        @endswitch
    @endforeach

@else
    {{-- ================================================================= --}}
    {{-- VISTA PREDETERMINADA DE RESPALDO (Si no hay bloques creados)     --}}
    {{-- ================================================================= --}}
    <!-- Hero Section con Promoción Destacada -->
    <section class="relative bg-gradient-to-br from-slate-900 via-blue-950 to-slate-900 text-white overflow-hidden py-16 lg:py-24">
        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#F58220_1px,transparent_1px)] [background-size:16px_16px]"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
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
                        <a href="{{ url('/promociones') }}" class="px-8 py-3.5 rounded-xl font-bold bg-marcsol-secondary hover:brightness-110 text-white shadow-lg transition-all flex items-center justify-center gap-2">
                            <span>Explorar Ofertas</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                        <a href="{{ url('/sucursales') }}" class="px-8 py-3.5 rounded-xl font-semibold bg-white/10 hover:bg-white/20 text-white backdrop-blur-md transition-all flex items-center justify-center gap-2">
                            <span>Nuestras Sucursales</span>
                        </a>
                    </div>
                </div>
                <div class="lg:col-span-5">
                    @if($promoDelDia)
                        <div class="relative rounded-3xl p-1 bg-gradient-to-tr from-amber-400 to-orange-500 shadow-2xl transition-transform hover:-translate-y-1">
                            <div class="bg-gray-900 rounded-[22px] p-6 text-white space-y-4">
                                <span class="px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider bg-red-600 text-white">
                                    🔥 Promoción del Día
                                </span>
                                @if($promoDelDia->imagen)
                                    <div class="h-48 rounded-xl overflow-hidden bg-gray-800">
                                        <img src="{{ asset('storage/' . $promoDelDia->imagen) }}" alt="{{ $promoDelDia->titulo }}" class="w-full h-full object-cover">
                                    </div>
                                @endif
                                <h3 class="text-2xl font-bold text-white">{{ $promoDelDia->titulo }}</h3>
                                <p class="text-sm text-gray-300 line-clamp-2">{{ $promoDelDia->descripcion }}</p>
                                <a href="{{ url('/promociones/' . $promoDelDia->slug) }}" class="font-bold text-amber-400 hover:text-amber-300 block text-xs">Ver Detalle →</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Categorías -->
    <section class="py-12 bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach($categorias as $cat)
                    <a href="{{ url('/promociones?categoria=' . $cat->slug) }}" class="p-4 rounded-2xl bg-gray-50 hover:bg-amber-50 border border-gray-100 text-center space-y-2 group">
                        <span class="text-2xl">🛒</span>
                        <h4 class="text-xs font-bold text-gray-800">{{ $cat->nombre }}</h4>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Grid de Promociones -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-black text-gray-900 mb-8">Nuestras Ofertas Destacadas</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($promociones as $promo)
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 space-y-3">
                        <h3 class="text-lg font-bold text-gray-900">{{ $promo->titulo }}</h3>
                        <p class="text-xs text-gray-500 line-clamp-2">{{ $promo->descripcion }}</p>
                        <a href="{{ url('/promociones/' . $promo->slug) }}" class="font-bold text-marcsol-primary text-xs">Ver Detalle →</a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
@endsection
