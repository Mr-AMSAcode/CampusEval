<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware LogUserActivity - Enregistrer les activités importantes
 */
class LogUserActivity
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Enregistrer l'activité de l'utilisateur
        if ($user = $request->user()) {
            if ($request->isMethod('post') || $request->isMethod('put') || $request->isMethod('delete')) {
                // Peu inefficace de logger à chaque requête, mais vous pouvez ajuster
                // \App\Models\AuditLog::create([
                //     'user_id' => $user->id,
                //     'action' => $request->method() . ' ' . $request->path(),
                //     'ip_address' => $request->ip(),
                //     'user_agent' => $request->userAgent(),
                // ]);
            }
        }

        return $response;
    }
}
