<?php 

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles)
    {
        $user = $request->user();

        if (!$user || !$user->roles()->whereIn('nombre', $roles)->exists()) {
            abort(403, 'Acceso no autorizado.');
        }

        return $next($request);
    }
}