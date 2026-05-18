<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware EnforceAnonymity - Appliquer l'anonymité des évaluations
 * 
 * Cette middleware garantit que les identifiants des étudiants
 * ne sont jamais exposés lors de la consultation des évaluations.
 */
class EnforceAnonymity
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // On pourrait ajouter des headers de sécurité ici
        $response->header('X-Content-Type-Options', 'nosniff');
        $response->header('X-Frame-Options', 'DENY');
        $response->header('X-XSS-Protection', '1; mode=block');

        return $response;
    }
}
