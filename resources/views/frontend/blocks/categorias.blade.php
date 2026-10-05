@php
    $catCollection = isset($categorias) ? $categorias : \App\Models\Category::where('status', true)->withCount('promotions')->get();
@endphp
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
            @foreach($catCollection as $cat)
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
                    <span class="text-[10px] text-gray-400 block">{{ $cat->promotions_count ?? 0 }} ofertas</span>
                </a>
            @endforeach
        </div>
    </div>
</section>
