<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user(); // Obtener el usuario autenticado

        if ($user) {
            if ($user->role === 'Profesor') {
                return redirect('/professor/selection');
            } elseif ($user->role === 'Estudiante') {
                return redirect('/student/selection');
            }
        }

        return $next($request);
    }
}
