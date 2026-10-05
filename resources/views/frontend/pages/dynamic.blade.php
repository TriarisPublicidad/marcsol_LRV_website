@extends('layouts.' . ($page->plantilla ?? 'app'))

@section('meta_title', $page->meta_title ?: $page->titulo . ' | Marcsol')
@section('meta_description', $page->meta_description ?: \Illuminate\Support\Str::limit(strip_tags($page->titulo . ' - Marcsol Quevedo'), 150))
@section('og_image', $page->og_image ? asset('storage/' . $page->og_image) : asset('images/og-default.jpg'))

@section('content')
<div class="space-y-4">
    @if(is_array($page->contenido_json_bloques) && count($page->contenido_json_bloques) > 0)
        <x-page-blocks
            :blocks="$page->contenido_json_bloques"
            :promo-del-dia="$promoDelDia ?? null"
            :promociones="$promociones ?? null"
            :eventos="$eventos ?? null"
            :sucursales="$sucursales ?? null"
            :categorias="$categorias ?? null"
        />
    @else
        <div class="max-w-4xl mx-auto px-4 py-20 text-center space-y-4">
            <h1 class="text-3xl sm:text-4xl font-black text-gray-900">{{ $page->titulo }}</h1>
            <p class="text-gray-500 max-w-md mx-auto">Esta página aún no contiene bloques de contenido configurados en el panel de administración.</p>
            <div class="pt-4">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-marcsol-primary text-white text-sm font-bold shadow hover:brightness-110 transition">
                    ← Volver a la Portada
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
