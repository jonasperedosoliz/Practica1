<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! $user->is_admin) {
            if ($user) {
                return redirect()
                    ->route('catalogo')
                    ->with('status', 'Su cuenta solo tiene acceso al catálogo de productos.');
            }

            return redirect()->route('login');
        }

        return $next($request);
    }
}
