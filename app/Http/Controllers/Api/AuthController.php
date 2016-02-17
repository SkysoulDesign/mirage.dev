<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\Users\CreateUserJob;
use App\Jobs\Users\GenerateTokenJob;
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
     * Create User
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function register(Request $request)
    {

        $validator = $this->getValidationFactory()->make($request->all(), [
            'username'   => 'required|alpha_dash',
            'email'      => 'required|email|unique:users',
            'password'   => 'required|confirmed|min:6',
            'gender'     => 'string',
            'age'        => 'string',
            'terms'      => 'accepted',
            'country_id' => 'exists:countries,id',
        ]);

        if ($validator->fails())
            return response()->json(['error' => $validator->errors()]);

        $token = dispatch(new CreateUserJob($request->all()));

        return response()->json(compact('token'));

    }

    /**
     * Login In User
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function authenticate(Request $request)
    {

        $validator = $this->getValidationFactory()->make($request->toArray(), [
            'credential' => 'required',
            'password'   => 'required|min:6'
        ]);

        if ($validator->fails())
            return response()->json(['error' => $validator->errors()]);

        $field = filter_var($request->input('credential'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $request->merge([$field => $request->input('credential')]);

        if (!$this->auth->attempt($request->only($field, 'password')))
            return response()->json(['error' => 'invalid_username_or_password']);

        $token = dispatch(new GenerateTokenJob($this->auth->user(), true));

        return response()->json(compact('token'));

    }

}