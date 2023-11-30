<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CheckRoleWeb
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user_role = Auth::user()->role;
        // dd($user_role);
        foreach ($roles as $role) {
            // If current role matches given role, return request
            if ($user_role === $role) {
                return $next($request);
            }
        }

        abort(403);
    }
}
