<?php

namespace App\Http\Middleware;

use App\Models\Redirect301;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Redirect301Middleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Solo para solicitudes GET y HEAD que no sean del admin ni assets
        if ($request->isMethodSafe() && ! $request->is('admin*') && ! $request->is('livewire*')) {
            $path = '/' . ltrim($request->path(), '/');
            $fullUri = $request->getRequestUri();

            $redirect = Redirect301::active()
                ->where(function ($query) use ($path, $fullUri) {
                    $query->where('url_origen', $path)
                        ->orWhere('url_origen', $fullUri);
                })
                ->first();

            if ($redirect) {
                // Registrar hit
                $redirect->increment('hits');

                return redirect()->to($redirect->url_destino, 301);
            }
        }

        return $next($request);
    }
}
