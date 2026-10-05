@extends('layouts.app')

@section('meta_title', $evento->meta_title ?: $evento->titulo . ' | Eventos Marcsol')
@section('meta_description', $evento->meta_description ?: \Illuminate\Support\Str::limit(strip_tags($evento->descripcion), 150))
@section('og_image', $evento->og_image ? asset('storage/' . $evento->og_image) : ($evento->imagen ? asset('storage/' . $evento->imagen) : asset('images/og-default.jpg')))

@section('content')
<div class="bg-gray-100 py-6 border-b border-gray-200 text-xs">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center gap-2 text-gray-500">
        <a href="{{ url('/') }}" class="hover:text-marcsol-primary">Inicio</a>
        <span>/</span>
        <a href="{{ url('/eventos') }}" class="hover:text-marcsol-primary">Eventos</a>
        <span>/</span>
        <span class="text-gray-800 font-semibold truncate">{{ $evento->titulo }}</span>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-3xl p-8 sm:p-12 shadow-sm border border-gray-100 space-y-8">
        <div class="space-y-4">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-100 text-amber-900 text-xs font-bold">
                <svg class="w-4 h-4 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                {{ $evento->fecha_evento->format('d/m/Y - H:i') }}
            </div>

            <h1 class="text-3xl sm:text-4xl font-black text-gray-900 leading-tight">
                {{ $evento->titulo }}
            </h1>

            <div class="flex items-center gap-4 text-sm text-gray-600 pt-2">
                <span>📍 <strong>Lugar:</strong> {{ $evento->lugar }}</span>
                @if($evento->branch)
                    <span>• <strong>Sucursal:</strong> {{ $evento->branch->nombre }}</span>
                @endif
            </div>
        </div>

        @if($evento->imagen)
            <div class="rounded-2xl overflow-hidden shadow-sm">
                <img src="{{ asset('storage/' . $evento->imagen) }}" alt="{{ $evento->titulo }}" class="w-full object-cover">
            </div>
        @endif

        <div class="prose prose-base text-gray-700 leading-relaxed pt-4 border-t border-gray-100">
            {!! nl2br(e($evento->descripcion)) !!}
        </div>

        <div class="pt-8 border-t border-gray-100 flex flex-wrap gap-4 items-center justify-between">
            <a href="{{ url('/eventos') }}" class="text-sm font-bold text-gray-600 hover:text-marcsol-primary">
                ← Volver a Eventos
            </a>
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['company_whatsapp'] ?? '593997654321') }}?text=Hola,%20quisiera%20mas%20informacion%20del%20evento:%20{{ urlencode($evento->titulo) }}" target="_blank" rel="noopener" class="px-6 py-3 rounded-xl font-bold bg-emerald-600 hover:bg-emerald-500 text-white text-sm shadow-md transition-all flex items-center gap-2">
                <span>Consultar por WhatsApp</span>
            </a>
        </div>
    </div>
</div>
@endsection
