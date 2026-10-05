<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Promotion;
use Illuminate\View\View;

class PageController extends Controller
{
    public function show(string $slug): View
    {
        $page = Page::active()->where('slug', $slug)->firstOrFail();

        // En caso de que contenga el bloque 'grid_promociones', cargamos promociones dinÃ¡micamente
        $promociones = collect();
        if (is_array($page->contenido_json_bloques)) {
            foreach ($page->contenido_json_bloques as $bloque) {
                if (($bloque['type'] ?? '') === 'grid_promociones') {
                    $limite = (int) ($bloque['data']['limite'] ?? 6);
                    $soloDestacadas = (bool) ($bloque['data']['solo_destacadas'] ?? false);

                    $q = Promotion::active()->latest();
                    if ($soloDestacadas) {
                        $q->where('es_promocion_del_dia', true);
                    }
                    $promociones = $q->take($limite)->get();
                    break;
                }
            }
        }

        return view('frontend.pages.dynamic', compact('page', 'promociones'));
    }
}
