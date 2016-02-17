<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {

        if (!$request->user()->is($role)) {
            return redirect()->back()->withErrors('You have no permissions to open this URL');
        }

        return $next($request);

    }
}
