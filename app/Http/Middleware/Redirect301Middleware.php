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

            $map = Redirect301::getCachedMap();

            $destination = $map[$path] ?? $map[$fullUri] ?? null;

            if ($destination) {
                // Registrar hit sin bloquear
                try {
                    Redirect301::where('url_origen', $path)->orWhere('url_origen', $fullUri)->increment('hits');
                } catch (\Throwable $e) {
                    // Fallback silencioso
                }

                return redirect()->to($destination, 301);
            }
        }

        return $next($request);
    }
}
