<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware EnsureEmailVerified - Vérifier que l'email est validé
 */
class EnsureEmailVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || !$user->email_verified_at) {
            return redirect()->route('verification.notice');
        }

        return $next($request);
    }
}
