@props([
    'blocks' => [],
    'promoDelDia' => null,
    'promociones' => null,
    'eventos' => null,
    'sucursales' => null,
    'categorias' => null,
])

@if(is_array($blocks) && count($blocks) > 0)
    @foreach($blocks as $bloque)
        @php
            $type = $bloque['type'] ?? '';
            $data = $bloque['data'] ?? [];
        @endphp

        @includeIf('frontend.blocks.' . $type, [
            'data' => $data,
            'bloque' => $bloque,
            'promoDelDia' => $promoDelDia,
            'promociones' => $promociones,
            'eventos' => $eventos,
            'sucursales' => $sucursales,
            'categorias' => $categorias,
        ])
    @endforeach
@endif
