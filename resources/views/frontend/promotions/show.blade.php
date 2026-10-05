@extends('layouts.app')

@section('meta_title', $promocion->meta_title ?: $promocion->titulo . ' | Marcsol Quevedo')
@section('meta_description', $promocion->meta_description ?: \Illuminate\Support\Str::limit(strip_tags($promocion->descripcion), 150))
@section('og_image', $promocion->og_image ? asset('storage/' . $promocion->og_image) : ($promocion->imagen ? asset('storage/' . $promocion->imagen) : asset('images/og-default.jpg')))

@section('content')
<div class="bg-gray-100 py-6 border-b border-gray-200 text-xs">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center gap-2 text-gray-500">
        <a href="{{ url('/') }}" class="hover:text-marcsol-primary">Inicio</a>
        <span>/</span>
        <a href="{{ url('/promociones') }}" class="hover:text-marcsol-primary">Promociones</a>
        <span>/</span>
        <span class="text-gray-800 font-semibold truncate">{{ $promocion->titulo }}</span>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
        <!-- Imagen / Banner -->
        <div class="lg:col-span-6 bg-white p-4 rounded-3xl shadow-sm border border-gray-100">
            @if($promocion->banner)
                <img src="{{ asset('storage/' . $promocion->banner) }}" alt="{{ $promocion->titulo }}" class="w-full rounded-2xl object-cover shadow-sm">
            @elseif($promocion->imagen)
                <img src="{{ asset('storage/' . $promocion->imagen) }}" alt="{{ $promocion->titulo }}" class="w-full rounded-2xl object-cover shadow-sm">
            @else
                <div class="h-80 bg-gray-50 rounded-2xl flex items-center justify-center text-marcsol-primary">
                    <svg class="w-16 h-16 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                </div>
            @endif
        </div>

        <!-- Información Detallada -->
        <div class="lg:col-span-6 space-y-6">
            <div class="flex flex-wrap items-center gap-2">
                @if($promocion->es_promocion_del_dia)
                    <span class="px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider bg-red-600 text-white shadow-sm">
                        ⭐ Promoción del Día
                    </span>
                @endif
                @if($promocion->category)
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-marcsol-primary">
                        {{ $promocion->category->nombre }}
                    </span>
                @endif
                <span class="px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
                    📍 {{ $promocion->branch ? $promocion->branch->nombre : 'Todas las sucursales en Quevedo' }}
                </span>
            </div>

            <h1 class="text-3xl sm:text-4xl font-black text-gray-900 leading-tight">
                {{ $promocion->titulo }}
            </h1>

            <div class="p-4 bg-amber-50 border border-amber-200 rounded-2xl text-xs text-amber-900 space-y-1">
                <p class="font-bold flex items-center gap-1.5 text-amber-800">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Vigencia de la Oferta:
                </p>
                <p>
                    Desde: <strong>{{ $promocion->fecha_inicio ? $promocion->fecha_inicio->format('d/m/Y H:i') : 'Inmediata' }}</strong>
                    hasta: <strong>{{ $promocion->fecha_fin ? $promocion->fecha_fin->format('d/m/Y H:i') : 'Agotar existencias' }}</strong>
                </p>
            </div>

            <div class="prose prose-sm text-gray-600 leading-relaxed">
                {!! nl2br(e($promocion->descripcion)) !!}
            </div>

            <div class="pt-6 border-t border-gray-200 flex flex-wrap gap-4 items-center">
                <!-- Botón Volante PDF -->
                @if($promocion->pdf_volante)
                    <a href="{{ asset('storage/' . $promocion->pdf_volante) }}" target="_blank" download class="px-6 py-3 rounded-xl text-sm font-bold bg-marcsol-primary hover:bg-blue-900 text-white shadow-md transition-all flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Descargar Volante Digital (PDF)
                    </a>
                @endif

                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['company_whatsapp'] ?? '593997654321') }}?text=Hola,%20deseo%20consultar%20sobre%20la%20promocion:%20{{ urlencode($promocion->titulo) }}" target="_blank" rel="noopener" class="px-6 py-3 rounded-xl text-sm font-bold bg-emerald-600 hover:bg-emerald-500 text-white shadow-md transition-all flex items-center gap-2">
                    <span>Consultar por WhatsApp</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Promociones Relacionadas -->
    @if($relacionadas->count() > 0)
        <div class="mt-20 pt-12 border-t border-gray-200">
            <h3 class="text-2xl font-black text-gray-900 mb-8">Otras Ofertas que te pueden interesar</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($relacionadas as $rel)
                    <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 p-4 space-y-3">
                        <h4 class="font-bold text-gray-900 text-sm hover:text-marcsol-primary">
                            <a href="{{ url('/promociones/' . $rel->slug) }}">{{ $rel->titulo }}</a>
                        </h4>
                        <p class="text-xs text-gray-500 line-clamp-2">{{ $rel->descripcion }}</p>
                        <a href="{{ url('/promociones/' . $rel->slug) }}" class="text-xs font-bold text-marcsol-primary block text-right">Ver oferta →</a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
