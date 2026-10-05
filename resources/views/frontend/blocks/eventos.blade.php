@php
    $limiteEventos = (int) ($data['limite'] ?? 3);
    $eventosCollection = isset($eventos) ? $eventos : \App\Models\Event::upcoming()->with('branch')->take($limiteEventos)->get();
    $eventosMostrar = $eventosCollection->take($limiteEventos);
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
