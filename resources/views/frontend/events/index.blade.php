@extends('layouts.app')

@section('meta_title', 'Eventos, Ferias y Sorteos | Marcsol Quevedo')
@section('meta_description', 'Descubre las degustaciones, festivales parrilleros, ruletas y actividades familiares en los locales de Marcsol en Quevedo.')

@section('content')
<div class="bg-slate-900 py-12 text-white border-b border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <span class="text-xs font-bold uppercase tracking-wider text-amber-400">Comunidad & Familia</span>
        <h1 class="text-3xl sm:text-4xl font-black tracking-tight mt-1">Eventos y Activaciones</h1>
        <p class="text-sm text-gray-300 mt-2 max-w-2xl">Acompáñanos a nuestras ferias, festivales gastronómicos y sorteos en Quevedo.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="space-y-12">
        <!-- Próximos Eventos -->
        <div>
            <h2 class="text-2xl font-black text-gray-900 mb-6">Próximas Fechas</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($eventosProximos as $evento)
                    <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl border border-gray-100 transition-all flex flex-col justify-between group">
                        <div>
                            @if($evento->imagen)
                                <div class="h-48 overflow-hidden bg-gray-100">
                                    <img src="{{ asset('storage/' . $evento->imagen) }}" alt="{{ $evento->titulo }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                </div>
                            @endif

                            <div class="p-6 space-y-3">
                                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-marcsol-primary text-xs font-bold">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    {{ $evento->fecha_evento->format('d/m/Y - H:i') }}
                                </div>

                                <h3 class="text-xl font-bold text-gray-900 group-hover:text-marcsol-primary transition-colors">
                                    <a href="{{ url('/eventos/' . $evento->slug) }}">
                                        {{ $evento->titulo }}
                                    </a>
                                </h3>

                                <p class="text-xs text-gray-500 line-clamp-3 leading-relaxed">
                                    {{ $evento->descripcion }}
                                </p>
                            </div>
                        </div>

                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-between text-xs">
                            <span class="text-gray-500 font-medium truncate max-w-[200px]">
                                📍 {{ $evento->lugar }}
                            </span>
                            <a href="{{ url('/eventos/' . $evento->slug) }}" class="font-bold text-marcsol-primary hover:underline">
                                Ver Detalles →
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-12 bg-white rounded-2xl border border-gray-100 text-gray-500">
                        No hay eventos programados en este momento. ¡Vuelve pronto para nuevas sorpresas!
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $eventosProximos->links() }}
            </div>
        </div>

        <!-- Eventos Pasados -->
        @if($eventosPasados->count() > 0)
            <div class="pt-12 border-t border-gray-200">
                <h3 class="text-xl font-bold text-gray-800 mb-6">Actividades Anteriores</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    @foreach($eventosPasados as $ep)
                        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm opacity-80 hover:opacity-100 transition-opacity">
                            <span class="text-[10px] text-gray-400 font-bold uppercase">{{ $ep->fecha_evento->format('d/m/Y') }}</span>
                            <h4 class="text-sm font-bold text-gray-900 mt-1">{{ $ep->titulo }}</h4>
                            <p class="text-xs text-gray-500 line-clamp-2 mt-2">{{ $ep->descripcion }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
