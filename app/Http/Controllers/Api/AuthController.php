<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\Users\CheckTokenJob;
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
            'username'   => 'required|alpha_dash|unique:users',
            'email'      => 'required|email|unique:users',
            'password'   => 'required|confirmed|min:6',
            'gender'     => 'string',
            'age_id'     => 'exists:ages,id',
            'country_id' => 'exists:countries,id',
            'terms'      => 'accepted'
        ]);

        if ($validator->fails())
            return response()->json(['error' => $validator->errors()]);

        $user = dispatch(new CreateUserJob($request->all()));

        return response()->json(collect($user)->except('id', 'remember_token', 'created_at', 'updated_at'));

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

        dispatch(new GenerateTokenJob($this->auth->user(), true));

        return response()->json(collect($this->auth->user())->except('id', 'remember_token', 'created_at', 'updated_at'));

    }

    /**
     * Check if user is valid
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function check(Request $request)
    {

        $result = dispatch(new CheckTokenJob($request->get('api_token')));

        if ($result) {
            return response()->json(['error', 'login_login_expired']);
        }

        return response()->json(['status' => 'okay']);

    }

}