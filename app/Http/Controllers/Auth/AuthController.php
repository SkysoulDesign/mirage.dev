<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
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

        $field = filter_var($request->input('credential'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $request->merge([$field => $request->input('credential')]);

        if (!$this->auth->attempt($request->only($field, 'password')))
            return redirect()->back()->withInput()->withErrors('Username or Password Not Found');

        return redirect()->route('home');

    }

    /**
     * Display Generator Page
     */
    public function logout()
    {
        $this->auth->logout();
        return redirect()->route('login');
    }

}