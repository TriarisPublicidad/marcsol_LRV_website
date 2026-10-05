<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PromotionController extends Controller
{
    public function index(Request $request): View
    {
        $query = Promotion::active()->with(['category', 'branch']);

        if ($request->filled('categoria')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->categoria);
            });
        }

        if ($request->filled('sucursal')) {
            $query->where(function ($q) use ($request) {
                $q->whereHas('branch', function ($b) use ($request) {
                    $b->where('slug', $request->sucursal);
                })->orWhereNull('sucursal_id');
            });
        }

        if ($request->boolean('solo_dia')) {
            $query->where('es_promocion_del_dia', true);
        }

        $promociones = $query->latest()->paginate(9)->withQueryString();
        $categorias = Category::where('status', true)->get();
        $sucursales = Branch::where('status', true)->get();

        return view('frontend.promotions.index', compact('promociones', 'categorias', 'sucursales'));
    }

    public function show(string $slug): View
    {
        $promocion = Promotion::active()
            ->where('slug', $slug)
            ->with(['category', 'branch'])
            ->firstOrFail();

        $relacionadas = Promotion::active()
            ->where('id', '!=', $promocion->id)
            ->where('category_id', $promocion->category_id)
            ->take(3)
            ->get();

        return view('frontend.promotions.show', compact('promocion', 'relacionadas'));
    }
}
