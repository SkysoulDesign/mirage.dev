<?php

namespace App\Http\Middleware;

use Closure;

class ProxyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $request->setTrustedProxies([
            '114.55.103.163',
            '223.197.27.204',
            $request->getClientIp()
        ]);

        return $next($request);
    }
}
