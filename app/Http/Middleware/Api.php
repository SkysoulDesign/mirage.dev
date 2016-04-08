<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Auth\Guard;

class Api
{
    /**
     * @var Guard
     */
    private $auth;

    /**
     * Api constructor.
     * @param AuthManager $auth
     */
    public function __construct(AuthManager $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        /**
         * if has no token then return
         */
        if (!$request->has('api_token'))
            return response()->json(['error' => 'token_not_provided']);

        /**
         * If language not sent from Device
         */
//        if (!$request->has('language'))
//            return response()->json(['error' => 'language_not_provided']);

        if (!$this->auth->guard('api')->user())
            return response()->json(['error' => 'invalid_token']);

        return $next($request);

    }

}