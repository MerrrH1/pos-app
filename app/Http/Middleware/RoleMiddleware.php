<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param string ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles): mixed
    {
        $user = Auth::user();

        // if($user && in_array($user->role, $roles)) {
        //     return $next($request);
        // }
        if(!in_array($user->role, $roles) || !$user) {
            abort(403, "Unauthorized");
        }
        // abort(403, "Unauthorized");
        return $next($request);
    }
}
