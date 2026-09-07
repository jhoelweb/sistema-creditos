<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Manejar la solicitud.
     */
    public function handle(
        Request $request,
        Closure $next,
        string $rol
    ): Response {
        // Verificar que el usuario esté autenticado
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Verificar que tenga el rol requerido
        if (auth()->user()->rol !== $rol) {
            abort(
                403,
                'No tienes permisos para realizar esta acción.'
            );
        }

        return $next($request);
    }
}
