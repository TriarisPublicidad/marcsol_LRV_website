@php
    $sucursalesCollection = isset($sucursales) ? $sucursales : \App\Models\Branch::where('status', true)->get();
@endphp
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
            @foreach($sucursalesCollection as $sucursal)
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-900">{{ $sucursal->nombre }}</h3>
                        <span class="px-2 py-0.5 text-[10px] font-bold uppercase bg-emerald-100 text-emerald-700 rounded">Abierto</span>
                    </div>

                    <p class="text-xs text-gray-500 leading-relaxed flex items-start gap-1.5">
                        <svg class="w-3.5 h-3.5 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>{{ $sucursal->direccion }}</span>
                    </p>

                    <div class="text-xs text-gray-600 bg-gray-50 p-3 rounded-xl space-y-1">
                        <p class="font-medium text-gray-700 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Horario:</span>
                        </p>
                        <p>{{ $sucursal->horarios ?? '07:30 a 21:00' }}</p>
                    </div>

                    <div class="pt-2 flex items-center justify-between">
                        @if($sucursal->telefono)
                            <a href="tel:{{ $sucursal->telefono }}" class="text-xs font-semibold text-gray-700 hover:text-marcsol-primary flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                <span>{{ $sucursal->telefono }}</span>
                            </a>
                        @endif
                        <a href="{{ url('/sucursales/' . $sucursal->slug) }}" class="text-xs font-bold text-marcsol-primary hover:underline">
                            Ver Mapa →
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
