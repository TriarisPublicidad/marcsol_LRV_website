<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(): View
    {
        $eventosProximos = Event::upcoming()
            ->with('branch')
            ->paginate(9);

        $eventosPasados = Event::active()
            ->where('fecha_evento', '<', now())
            ->with('branch')
            ->latest('fecha_evento')
            ->take(3)
            ->get();

        return view('frontend.events.index', compact('eventosProximos', 'eventosPasados'));
    }

    public function show(string $slug): View
    {
        $evento = Event::active()
            ->where('slug', $slug)
            ->with('branch')
            ->firstOrFail();

        $otrosEventos = Event::upcoming()
            ->where('id', '!=', $evento->id)
            ->take(3)
            ->get();

        return view('frontend.events.show', compact('evento', 'otrosEventos'));
    }
}
