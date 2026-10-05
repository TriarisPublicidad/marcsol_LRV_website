@php
    $posicion = $data['posicion_imagen'] ?? 'derecha';
@endphp
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
        <div class="lg:col-span-7 space-y-6 {{ $posicion === 'izquierda' ? 'lg:order-2' : '' }}">
            @if(!empty($data['titulo']))
                <h2 class="text-3xl sm:text-4xl font-black text-gray-900 tracking-tight leading-tight">
                    {{ $data['titulo'] }}
                </h2>
            @endif
            <div class="prose prose-base text-gray-600 leading-relaxed space-y-4">
                {!! nl2br(e($data['contenido'] ?? '')) !!}
            </div>
        </div>

        <div class="lg:col-span-5 {{ $posicion === 'izquierda' ? 'lg:order-1' : '' }}">
            @if(!empty($data['imagen']))
                <div class="rounded-3xl overflow-hidden shadow-xl border border-gray-100 group">
                    <img src="{{ asset('storage/' . $data['imagen']) }}" alt="{{ $data['titulo'] ?? 'Imagen' }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
            @else
                <div class="h-72 rounded-3xl bg-gradient-to-br from-blue-50 to-amber-50 border border-gray-100 flex items-center justify-center text-marcsol-primary">
                    <svg class="w-20 h-20 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
            @endif
        </div>
    </div>
</section>
