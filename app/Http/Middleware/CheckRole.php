<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware CheckRole - Vérifier le rôle de l'utilisateur
 * 
 * Usage: Route::middleware(['role:super_admin,teacher'])->group(...)
 */
class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            abort(401); // Non authentifié
        }

        if (!in_array($user->role, $roles)) {
            abort(403); // Accès refusé
        }

        return $next($request);
    }
}
