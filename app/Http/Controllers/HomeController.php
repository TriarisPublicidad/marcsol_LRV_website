<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Event;
use App\Models\Promotion;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $promoDelDia = Promotion::active()
            ->where('es_promocion_del_dia', true)
            ->with(['category', 'branch'])
            ->latest('fecha_inicio')
            ->first();

        $promociones = Promotion::active()
            ->with(['category', 'branch'])
            ->latest()
            ->take(6)
            ->get();

        $eventos = Event::upcoming()
            ->with('branch')
            ->take(3)
            ->get();

        $sucursales = Branch::where('status', true)->get();
        $categorias = Category::where('status', true)->withCount('promotions')->get();

        return view('frontend.home', compact('promoDelDia', 'promociones', 'eventos', 'sucursales', 'categorias'));
    }
}
