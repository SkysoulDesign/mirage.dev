<?php

namespace App\Http\Controllers;

use App\Jobs\Users\CreateUserJob;
use App\Models\Age;
use App\Models\Country;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    /**
     * Display Generator Page
     * @param User $user
     * @return $this
     */
    public function index(User $user)
    {
        return view('users.index')->with('users', $user->all());
    }

    /**
     * Create user
     * @param Role $role
     * @param Country $country
     * @param Age $age
     * @return \Illuminate\View\View
     */
    public function create(Role $role, Country $country, Age $age)
    {
        return view('users.create')
            ->with('roles', $role->all())
            ->with('countries', $country->all())
            ->with('ages', $age->all());
    }

    /**
     * Create Product
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function post(Request $request)
    {

        $this->validate($request, [
            'username'   => 'required|alpha_dash',
            'email'      => 'required|email|unique:users',
            'password'   => 'required|confirmed|min:6',
            'gender'     => 'string',
            'age_id'     => 'exists:ages,id',
            'terms'      => 'required|accepted',
            'role_id'    => 'required|exists:roles,id',
            'country_id' => 'exists:countries,id',
        ]);

        /**
         * Create User
         */
        dispatch(new CreateUserJob($request->except('role_id', 'country_id', 'age_id'), $request->get('role_id'), $request->get('country_id'), $request->get('age_id')));

        return redirect()->route('user.index');

    }

}