<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Verificar autenticación y roles
        if (
            !auth()->check() ||
            !auth()->user()->roles()->whereIn('name', $roles)->exists()
        ) {
            abort(403, 'Unauthorized access');
        }

        return $next($request);
    }
}