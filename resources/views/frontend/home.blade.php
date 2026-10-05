@extends('layouts.app')

@section('meta_title', $page?->meta_title ?? 'Marcsol | Supermercado Corporativo en Quevedo')
@section('meta_description', $page?->meta_description ?? 'Supermercado líder en Quevedo. Ahorra en alimentos, carnes, lácteos y productos del hogar.')
@section('og_image', $page?->og_image ? asset('storage/' . $page->og_image) : asset('images/og-default.jpg'))

@section('content')
    @if($page && is_array($page->contenido_json_bloques) && count($page->contenido_json_bloques) > 0)
        <x-page-blocks
            :blocks="$page->contenido_json_bloques"
            :promo-del-dia="$promoDelDia"
            :promociones="$promociones"
            :eventos="$eventos"
            :sucursales="$sucursales"
            :categorias="$categorias"
        />
    @else
        {{-- Fallback estándar si no hay bloques configurados --}}
        @include('frontend.blocks.hero', ['data' => [], 'promoDelDia' => $promoDelDia])
        @include('frontend.blocks.grid_promociones', ['data' => ['limite' => 6], 'promociones' => $promociones])
        @include('frontend.blocks.categorias', ['data' => [], 'categorias' => $categorias])
        @include('frontend.blocks.eventos', ['data' => ['limite' => 3], 'eventos' => $eventos])
        @include('frontend.blocks.sucursales', ['data' => [], 'sucursales' => $sucursales])
        @include('frontend.blocks.beneficios', ['data' => []])
        @include('frontend.blocks.banner_cta', ['data' => []])
    @endif
@endsection
