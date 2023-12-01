<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;
use Illuminate\Support\Facades\Log;

class RedirectIfNotAuthorized
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, ...$roles): Response
    {
        try {
            $token = JWTAuth::parseToken();
            $user = $token->authenticate();

            if (!$user || !in_array($user->user_type, $roles)) {
                // Redirect to the unauthorized page
                return redirect('/unauthorized');
            }

            return $next($request);
        } catch (Exception $e) {
            // Token is invalid, redirect to unauthorized page
            return redirect('/unauthorized');
        }
    }
}
