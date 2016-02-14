<?php

namespace App\Http\Controllers\TEMP;

use App\Http\Controllers\Controller;
use App\Jobs\Users\GenerateTokenCommand;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Cookie;

class AutahController extends Controller
{
    /**
     * @var Auth
     */
    private $auth;

    /**
     * AuthController constructor.
     * @param Auth $auth
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Display Generator Page
     */
    public function create()
    {
        return view('auth.create');
    }

    /**
     * Check Credentials and Log user In
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function post(Request $request)
    {

        $this->validate($request, [
            'credential' => 'required',
            'password'   => 'required|min:6'
        ]);

        if (!$user = $this->auth->user())
            return response()->json(['error' => 'invalid_credentials']);

        if ($user->api_token) {
            $token = $user->api_token;
        } else {
            $token = dispatch(new GenerateTokenCommand($user));
        }

        $cookie = app(Cookie::class, ['token', $token]);

        return redirect()->route('home')->withCookie($cookie);

    }

}