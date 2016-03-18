<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Jobs\Users\CreateUserJob;
use App\Models\Age;
use App\Models\Country;
use App\Models\Role;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Http\Request;

/**
 * Class AuthController
 * @package App\Http\Controllers\Auth
 */
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
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {

        if (filter_var($request->get('admin', false), FILTER_VALIDATE_BOOLEAN))
            return view('auth.create');

        return view('web.auth.login');
    }

    /**
     * Check Credentials and Log user In
     *
     * @param LoginRequest|Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function post(LoginRequest $request)
    {

        $field = filter_var($request->input('credential'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $request->merge([$field => $request->input('credential')]);

        if (!$this->auth->attempt($request->only($field, 'password')))
            return redirect()->back()->withInput()->withErrors('Username or Password Not Found');

        if ($request->get('user_type', '') == 'user')
            return redirect()->route('web.index');

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

    /**
     * @param Role $role
     * @param Country $country
     * @param Age $age
     * @return mixed
     */
    public function showRegistrationForm(Role $role, Country $country, Age $age)
    {
        $param = collect();

        return view('web.users.create', compact('param'))
            ->with('roles', $role->all())
            ->with('countries', $country->all())
            ->with('ages', $age->all());
    }

    /**
     * @param RegisterUserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function registerPost(RegisterUserRequest $request)
    {

        dispatch(new CreateUserJob($request->all(), 'user', $request->get('country_id'), $request->get('age_id')));

        return redirect()->route('web.index')->withSuccess('Account created successfully. You can login now');
    }

}