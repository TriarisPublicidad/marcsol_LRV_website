@extends('layouts.app')

@section('meta_title', 'Promociones y Catálogo de Ofertas | Marcsol Quevedo')
@section('meta_description', 'Aprovecha las ofertas del día, 3x2, descuentos en carnes, lácteos y abarrotes en todas las sucursales de Marcsol Quevedo.')

@section('content')
<div class="bg-slate-900 py-12 text-white border-b border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <span class="text-xs font-bold uppercase tracking-wider text-amber-400">Catálogo de Ahorro</span>
        <h1 class="text-3xl sm:text-4xl font-black tracking-tight mt-1">Promociones Activas</h1>
        <p class="text-sm text-gray-300 mt-2 max-w-2xl">Encuentra los descuentos vigentes en nuestras 3 sucursales de Quevedo.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Barra de Filtros -->
    <form method="GET" action="{{ url('/promociones') }}" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-8 space-y-4 md:space-y-0 md:flex md:items-center md:justify-between md:gap-4">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 flex-grow">
            <!-- Filtro Categoría -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-1">Categoría</label>
                <select name="categoria" onchange="this.form.submit()" class="w-full text-sm rounded-xl border-gray-200 focus:border-marcsol-primary focus:ring-0">
                    <option value="">Todas las categorías</option>
                    @foreach($categorias as $cat)
                        <option value="{{ $cat->slug }}" {{ request('categoria') === $cat->slug ? 'selected' : '' }}>
                            {{ $cat->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filtro Sucursal -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-1">Sucursal</label>
                <select name="sucursal" onchange="this.form.submit()" class="w-full text-sm rounded-xl border-gray-200 focus:border-marcsol-primary focus:ring-0">
                    <option value="">Todas las sucursales</option>
                    @foreach($sucursales as $suc)
                        <option value="{{ $suc->slug }}" {{ request('sucursal') === $suc->slug ? 'selected' : '' }}>
                            {{ $suc->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Switch Promo del Día -->
            <div class="flex items-center sm:pt-6">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="solo_dia" value="1" onchange="this.form.submit()" {{ request('solo_dia') ? 'checked' : '' }} class="rounded border-gray-300 text-marcsol-secondary focus:ring-0">
                    <span class="ml-2 text-xs font-bold text-gray-700">⭐ Solo Promo del Día</span>
                </label>
            </div>
        </div>

        @if(request()->hasAny(['categoria', 'sucursal', 'solo_dia']))
            <div>
                <a href="{{ url('/promociones') }}" class="px-4 py-2 text-xs font-semibold text-red-600 hover:text-red-700 bg-red-50 hover:bg-red-100 rounded-xl transition-colors">
                    Limpiar Filtros
                </a>
            </div>
        @endif
    </form>

    <!-- Grid de Promociones -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($promociones as $promo)
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl border border-gray-100 transition-all flex flex-col group">
                <div class="relative h-48 bg-gray-100 overflow-hidden">
                    @if($promo->imagen)
                        <img src="{{ asset('storage/' . $promo->imagen) }}" alt="{{ $promo->titulo }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-blue-50 text-marcsol-primary">
                            <svg class="w-12 h-12 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
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
                        <p class="text-xs text-gray-500 mt-2 line-clamp-3 leading-relaxed">
                            {{ $promo->descripcion }}
                        </p>
                    </div>

                    <div class="pt-4 border-t border-gray-100 flex items-center justify-between text-xs">
                        <span class="text-gray-400">
                            📍 {{ $promo->branch ? $promo->branch->nombre : 'Todas las sucursales' }}
                        </span>
                        <a href="{{ url('/promociones/' . $promo->slug) }}" class="font-bold text-marcsol-primary group-hover:underline">
                            Ver Detalle →
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-16 bg-white rounded-2xl border border-gray-100">
                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <h3 class="text-base font-bold text-gray-800">No encontramos promociones con esos filtros</h3>
                <p class="text-xs text-gray-500 mt-1">Prueba seleccionando otra categoría o sucursal.</p>
                <a href="{{ url('/promociones') }}" class="inline-block mt-4 text-xs font-bold text-marcsol-primary hover:underline">Ver todas las ofertas</a>
            </div>
        @endforelse
    </div>

    <!-- Paginación -->
    <div class="mt-12">
        {{ $promociones->links() }}
    </div>
</div>
@endsection
