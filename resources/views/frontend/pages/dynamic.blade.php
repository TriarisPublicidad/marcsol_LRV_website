@extends('layouts.app')

@section('meta_title', $page->meta_title ?: $page->titulo . ' | Marcsol')
@section('meta_description', $page->meta_description ?: \Illuminate\Support\Str::limit(strip_tags($page->titulo . ' - Marcsol Quevedo'), 150))
@section('og_image', $page->og_image ? asset('storage/' . $page->og_image) : asset('images/og-default.jpg'))

@section('content')
<div class="space-y-16 py-8">
    @if(is_array($page->contenido_json_bloques))
        @foreach($page->contenido_json_bloques as $bloque)
            @php
                $type = $bloque['type'] ?? '';
                $data = $bloque['data'] ?? [];
            @endphp

            @switch($type)
                {{-- BLOQUE 1: HERO --}}
                @case('hero')
                    <section class="relative bg-slate-900 text-white py-16 sm:py-24 rounded-3xl mx-4 sm:mx-8 overflow-hidden shadow-xl"
                        @if(!empty($data['imagen_fondo'])) style="background-image: linear-gradient(rgba(15, 23, 42, 0.8), rgba(15, 23, 42, 0.8)), url('{{ asset('storage/' . $data['imagen_fondo']) }}'); background-size: cover; background-position: center;" @endif>
                        <div class="max-w-4xl mx-auto px-6 text-center space-y-6">
                            <h1 class="text-4xl sm:text-5xl font-black tracking-tight leading-tight">
                                {{ $data['titulo'] ?? '' }}
                            </h1>
                            @if(!empty($data['subtitulo']))
                                <p class="text-lg text-gray-300 max-w-2xl mx-auto font-light leading-relaxed">
                                    {{ $data['subtitulo'] }}
                                </p>
                            @endif
                            @if(!empty($data['boton_texto']) && !empty($data['boton_url']))
                                <div class="pt-4">
                                    <a href="{{ $data['boton_url'] }}" class="inline-block px-8 py-3.5 rounded-xl font-bold bg-marcsol-secondary hover:brightness-110 text-white shadow-lg transition-all">
                                        {{ $data['boton_texto'] }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </section>
                    @break

                {{-- BLOQUE 2: TEXTO CON IMAGEN --}}
                @case('texto_imagen')
                    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                            @php
                                $posicion = $data['posicion_imagen'] ?? 'derecha';
                            @endphp

                            <div class="lg:col-span-7 space-y-6 {{ $posicion === 'izquierda' ? 'lg:order-2' : '' }}">
                                @if(!empty($data['titulo']))
                                    <h2 class="text-3xl font-black text-gray-900 tracking-tight">
                                        {{ $data['titulo'] }}
                                    </h2>
                                @endif
                                <div class="prose prose-base text-gray-600 leading-relaxed">
                                    {!! $data['contenido'] ?? '' !!}
                                </div>
                            </div>

                            <div class="lg:col-span-5 {{ $posicion === 'izquierda' ? 'lg:order-1' : '' }}">
                                @if(!empty($data['imagen']))
                                    <div class="rounded-3xl overflow-hidden shadow-lg border border-gray-100">
                                        <img src="{{ asset('storage/' . $data['imagen']) }}" alt="{{ $data['titulo'] ?? 'Imagen' }}" class="w-full object-cover">
                                    </div>
                                @else
                                    <div class="h-64 rounded-3xl bg-blue-50 border border-blue-100 flex items-center justify-center text-marcsol-primary">
                                        <svg class="w-16 h-16 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </section>
                    @break

                {{-- BLOQUE 3: GRID DE PROMOCIONES --}}
                @case('grid_promociones')
                    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 bg-gray-50 rounded-3xl">
                        <div class="text-center max-w-2xl mx-auto mb-10">
                            <h2 class="text-3xl font-black text-gray-900 tracking-tight">
                                {{ $data['titulo'] ?? 'Promociones Especiales' }}
                            </h2>
                            @if(!empty($data['subtitulo']))
                                <p class="text-sm text-gray-500 mt-2">{{ $data['subtitulo'] }}</p>
                            @endif
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($promociones as $promo)
                                <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 p-5 space-y-3 flex flex-col justify-between">
                                    <div>
                                        <span class="text-[10px] font-bold uppercase bg-amber-100 text-amber-900 px-2 py-0.5 rounded">
                                            {{ $promo->category->nombre ?? 'Oferta' }}
                                        </span>
                                        <h4 class="font-bold text-gray-900 text-base mt-2">
                                            <a href="{{ url('/promociones/' . $promo->slug) }}" class="hover:text-marcsol-primary">
                                                {{ $promo->titulo }}
                                            </a>
                                        </h4>
                                        <p class="text-xs text-gray-500 line-clamp-2 mt-1">{{ $promo->descripcion }}</p>
                                    </div>
                                    <div class="pt-3 border-t border-gray-100 flex items-center justify-between text-xs">
                                        <span class="text-gray-400">📍 {{ $promo->branch->nombre ?? 'Todas' }}</span>
                                        <a href="{{ url('/promociones/' . $promo->slug) }}" class="font-bold text-marcsol-primary">Ver detalle →</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                    @break

                {{-- BLOQUE 4: FAQS --}}
                @case('faqs')
                    <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ openFaq: null }">
                        <div class="text-center mb-8">
                            <h2 class="text-3xl font-black text-gray-900 tracking-tight">
                                {{ $data['titulo'] ?? 'Preguntas Frecuentes' }}
                            </h2>
                        </div>

                        @if(!empty($data['items']) && is_array($data['items']))
                            <div class="space-y-4">
                                @foreach($data['items'] as $index => $item)
                                    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm">
                                        <button type="button" @click="openFaq = (openFaq === {{ $index }} ? null : {{ $index }})"
                                            class="w-full p-5 text-left font-bold text-gray-900 flex justify-between items-center hover:bg-gray-50 transition-colors">
                                            <span>{{ $item['pregunta'] ?? '' }}</span>
                                            <svg class="w-5 h-5 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': openFaq === {{ $index }} }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                        </button>
                                        <div x-show="openFaq === {{ $index }}" x-collapse class="px-5 pb-5 text-sm text-gray-600 border-t border-gray-100 pt-3 leading-relaxed">
                                            {{ $item['respuesta'] ?? '' }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </section>
                    @break

            @endswitch
        @endforeach
    @else
        <div class="max-w-4xl mx-auto px-4 text-center py-16">
            <h1 class="text-3xl font-bold text-gray-900">{{ $page->titulo }}</h1>
            <p class="text-gray-500 mt-2">Esta página aún no contiene bloques de contenido configurados.</p>
        </div>
    @endif
</div>
@endsection
