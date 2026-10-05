@extends('layouts.app')

@section('meta_title', $sucursal->nombre . ' en Quevedo | Marcsol')
@section('meta_description', 'Dirección, horarios y promociones exclusivas en ' . $sucursal->nombre . ' de Marcsol en Quevedo, Los Ríos.')

@section('content')
<div class="bg-gray-100 py-6 border-b border-gray-200 text-xs">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center gap-2 text-gray-500">
        <a href="{{ url('/') }}" class="hover:text-marcsol-primary">Inicio</a>
        <span>/</span>
        <a href="{{ url('/sucursales') }}" class="hover:text-marcsol-primary">Sucursales</a>
        <span>/</span>
        <span class="text-gray-800 font-semibold truncate">{{ $sucursal->nombre }}</span>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        <!-- Ficha de Datos -->
        <div class="lg:col-span-6 space-y-6">
            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase bg-emerald-100 text-emerald-800">
                Atención Continua en Quevedo
            </span>

            <h1 class="text-3xl sm:text-4xl font-black text-gray-900 leading-tight">
                {{ $sucursal->nombre }}
            </h1>

            <div class="space-y-4 bg-white p-6 rounded-3xl border border-gray-100 shadow-sm text-sm">
                <div>
                    <h3 class="font-bold text-gray-900">📍 Dirección:</h3>
                    <p class="text-gray-600 mt-1">{{ $sucursal->direccion }}</p>
                </div>

                @if($sucursal->telefono)
                    <div>
                        <h3 class="font-bold text-gray-900">📞 Teléfono:</h3>
                        <p class="text-gray-600 mt-1">
                            <a href="tel:{{ $sucursal->telefono }}" class="text-marcsol-primary hover:underline font-semibold">
                                {{ $sucursal->telefono }}
                            </a>
                        </p>
                    </div>
                @endif

                @if($sucursal->email)
                    <div>
                        <h3 class="font-bold text-gray-900">✉️ Correo Electrónico:</h3>
                        <p class="text-gray-600 mt-1">{{ $sucursal->email }}</p>
                    </div>
                @endif

                <div>
                    <h3 class="font-bold text-gray-900">🕒 Horarios de Atención:</h3>
                    <p class="text-gray-600 mt-1">{{ $sucursal->horarios ?? 'Lunes a Sábado: 07:30 - 21:00 | Domingo: 08:00 - 19:00' }}</p>
                </div>
            </div>

            @if($sucursal->mapa_lat && $sucursal->mapa_lng)
                <a href="https://www.google.com/maps?q={{ $sucursal->mapa_lat }},{{ $sucursal->mapa_lng }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-marcsol-secondary hover:brightness-110 text-white font-bold text-sm shadow-md transition-all">
                    <span>Cómo Llegar (Google Maps)</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>
            @endif
        </div>

        <!-- Mapa Embebido OpenStreetMap / Fachada -->
        <div class="lg:col-span-6">
            <div class="bg-white p-3 rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                @if($sucursal->mapa_lat && $sucursal->mapa_lng)
                    <div class="h-96 rounded-2xl overflow-hidden">
                        <iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
                            src="https://www.openstreetmap.org/export/embed.html?bbox={{ $sucursal->mapa_lng - 0.005 }}%2C{{ $sucursal->mapa_lat - 0.005 }}%2C{{ $sucursal->mapa_lng + 0.005 }}%2C{{ $sucursal->mapa_lat + 0.005 }}&amp;layer=mapnik&amp;marker={{ $sucursal->mapa_lat }}%2C{{ $sucursal->mapa_lng }}">
                        </iframe>
                    </div>
                @else
                    <div class="h-96 bg-gray-100 rounded-2xl flex items-center justify-center text-gray-400">
                        Mapa no disponible
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
