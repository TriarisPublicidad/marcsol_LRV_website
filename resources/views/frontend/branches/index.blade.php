@extends('layouts.app')

@section('meta_title', 'Sucursales en Quevedo y Horarios de Atención | Marcsol')
@section('meta_description', 'Conoce las ubicaciones de nuestras 3 sucursales en Quevedo (Matriz Centro, San Camilo y El Guayacán), teléfonos y horarios de atención.')

@section('content')
<div class="bg-slate-900 py-12 text-white border-b border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <span class="text-xs font-bold uppercase tracking-wider text-amber-400">Red de Locales</span>
        <h1 class="text-3xl sm:text-4xl font-black tracking-tight mt-1">Nuestras Sucursales en Quevedo</h1>
        <p class="text-sm text-gray-300 mt-2 max-w-2xl">Encuentra la sucursal más cercana con amplios parqueaderos y atención personalizada.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        @foreach($sucursales as $sucursal)
            <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl border border-gray-100 transition-all flex flex-col justify-between group">
                <div>
                    @if($sucursal->imagen)
                        <div class="h-48 overflow-hidden bg-gray-100">
                            <img src="{{ asset('storage/' . $sucursal->imagen) }}" alt="{{ $sucursal->nombre }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </div>
                    @else
                        <div class="h-48 bg-gradient-to-tr from-blue-900 to-indigo-900 flex items-center justify-center text-white">
                            <div class="text-center">
                                <span class="text-4xl">🏬</span>
                                <h4 class="text-sm font-bold uppercase tracking-wider mt-2 opacity-80">Marcsol Quevedo</h4>
                            </div>
                        </div>
                    @endif

                    <div class="p-6 space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase bg-emerald-100 text-emerald-800">
                                Abierto Hoy
                            </span>
                            <span class="text-xs text-gray-400">Quevedo, Los Ríos</span>
                        </div>

                        <h3 class="text-2xl font-black text-gray-900 group-hover:text-marcsol-primary transition-colors">
                            <a href="{{ url('/sucursales/' . $sucursal->slug) }}">
                                {{ $sucursal->nombre }}
                            </a>
                        </h3>

                        <p class="text-xs text-gray-600 leading-relaxed">
                            📍 <strong>Dirección:</strong> {{ $sucursal->direccion }}
                        </p>

                        <div class="bg-gray-50 p-4 rounded-2xl text-xs text-gray-600 space-y-2">
                            <p class="font-bold text-gray-800 flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-marcsol-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Horario Habitual:
                            </p>
                            <p class="leading-relaxed">{{ $sucursal->horarios ?? 'Lunes a Domingo: 07:30 - 21:00' }}</p>
                        </div>
                    </div>
                </div>

                <div class="p-6 pt-0 space-y-2">
                    @if($sucursal->telefono)
                        <a href="tel:{{ $sucursal->telefono }}" class="w-full py-2.5 px-4 rounded-xl border border-gray-200 text-gray-700 text-xs font-bold hover:bg-gray-50 transition-colors flex items-center justify-center gap-2">
                            <span>📞 Llamar: {{ $sucursal->telefono }}</span>
                        </a>
                    @endif

                    @if($sucursal->mapa_lat && $sucursal->mapa_lng)
                        <a href="https://www.google.com/maps?q={{ $sucursal->mapa_lat }},{{ $sucursal->mapa_lng }}" target="_blank" rel="noopener" class="w-full py-2.5 px-4 rounded-xl bg-marcsol-primary hover:bg-blue-900 text-white text-xs font-bold transition-colors flex items-center justify-center gap-2">
                            <span>Abrir en Google Maps GPS</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
