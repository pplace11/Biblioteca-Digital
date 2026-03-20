<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// Middleware que restringe o acesso a rotas exclusivas de administradores.
class AdminMiddleware
{
    /** Verifica se o utilizador autenticado tem o papel de admin; caso contrario, aborta com 403. */
    public function handle($request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403);
        }

        return $next($request);
    }
}



