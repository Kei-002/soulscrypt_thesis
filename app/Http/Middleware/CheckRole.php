<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Traits\HttpResponses;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    use HttpResponses;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $token = $request->bearerToken();
        // 8|wUsOAP9UMTY2AxUcyXZXDnVCYhMIppPT43dc2eKN to [8, wUsOAP9UMTY2AxUcyXZXDnVCYhMIppPT43dc2eKN]
        $bearer_token = explode('|', $token);
        $id = $bearer_token[0];

        $token_info = DB::table('personal_access_tokens')
            ->where('id', $id)
            ->first();

        // Check if token is valid
        if (!$token_info) {
            return $this->error('', 'Token Denied/does not exist', 403);
        }

        // Get User Information
        $user = User::where('id', $token_info->tokenable_id)->first();
        
       
        // Iterate through roles that are passed to the middleware
        foreach ($roles as $role) {
            // If current role matches given role, return request
            if ($user->role === $role) {
                // Auth::login($user);
                return $next($request);
            }
        }

        return $this->error('', 'Access Forbidden/Denied', 403);
        // return $next($request);
    }
}
