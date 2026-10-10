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
                    @if($sucursal->imagen_url)
                        <div class="h-48 overflow-hidden bg-gray-100">
                            <img src="{{ $sucursal->imagen_url }}" alt="{{ $sucursal->nombre }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </div>
                    @else
                        <div class="h-48 bg-slate-800 flex items-center justify-center text-white">
                            <div class="text-center text-slate-400">
                                <svg class="w-12 h-12 mx-auto stroke-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.651V9.35m0 0a3.001 3.001 0 003.75-.614A2.993 2.993 0 009 9.35c.983-.913 2.502-.913 3.486 0a2.996 2.996 0 003.764 0 2.996 2.996 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.439 1.44a3.004 3.004 0 01-.62 4.72m-16.5 0c.315.293.714.46 1.135.474a2.986 2.986 0 001.365-.474m0 0a3 3 0 014 0m0 0a3 3 0 004 0m0 0a3 3 0 014 0" />
                                </svg>
                                <h4 class="text-xs font-semibold tracking-wider mt-2 uppercase text-slate-400">Marcsol Quevedo</h4>
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

                        <p class="text-xs text-gray-600 leading-relaxed flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-marcsol-primary shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span><strong>Dirección:</strong> {{ $sucursal->direccion }}</span>
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
