<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function show(): View
    {
        $sucursales = Branch::where('status', true)->get();

        return view('frontend.contact', compact('sucursales'));
    }

    public function submit(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:150',
            'email' => 'required|email|max:150',
            'telefono' => 'nullable|string|max:30',
            'tipo_solicitud' => 'required|string|in:corporativo,cliente,reclamo,proveedor',
            'sucursal' => 'nullable|string|max:100',
            'mensaje' => 'required|string|max:2000',
        ]);

        // Registrar en logs del sistema
        Log::info('Nuevo mensaje de contacto web Marcsol', $validated);

        return back()->with('success', '¡Gracias por comunicarte con Marcsol! Tu mensaje ha sido recibido por nuestro equipo de atención y te responderemos a la brevedad.');
    }
}
