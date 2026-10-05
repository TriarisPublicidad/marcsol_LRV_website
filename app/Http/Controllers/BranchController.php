<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\View\View;

class BranchController extends Controller
{
    public function index(): View
    {
        $sucursales = Branch::where('status', true)
            ->withCount(['promotions', 'events'])
            ->get();

        return view('frontend.branches.index', compact('sucursales'));
    }

    public function show(string $slug): View
    {
        $sucursal = Branch::where('status', true)
            ->where('slug', $slug)
            ->with(['promotions' => fn ($q) => $q->active()->latest()->take(4), 'events' => fn ($q) => $q->upcoming()->take(2)])
            ->firstOrFail();

        return view('frontend.branches.show', compact('sucursal'));
    }
}
