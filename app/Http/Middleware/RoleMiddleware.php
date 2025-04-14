<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Verifica que el usuario esté autenticado
        if (!$request->user()) {
            abort(403, 'No autorizado');
        }

        // Verifica si el usuario tiene el rol correcto
        if (strcasecmp($request->user()->role, $role) !== 0) {
            abort(403, 'Acceso denegado');
        }
        return $next($request);
        
        
    }
}


