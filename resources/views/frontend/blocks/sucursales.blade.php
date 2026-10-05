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
                            Ver Mapa →
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
