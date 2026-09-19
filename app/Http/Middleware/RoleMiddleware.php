<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Uso en rutas: ->middleware('role:paciente') o ->middleware('role:administrador')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            abort(401, 'No autenticado.');
        }

        if (!$user->roles()->whereIn('nombre', $roles)->exists()) {
            abort(403, 'Acceso no autorizado.');
        }

        return $next($request);
    }
}