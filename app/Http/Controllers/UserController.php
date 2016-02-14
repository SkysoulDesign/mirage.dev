<?php

namespace App\Http\Controllers;

use App\Jobs\Users\CreateUserJob;
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
     * @return \Illuminate\View\View
     */
    public function create(Role $role)
    {
        return view('users.create')->with('roles', $role->all());
    }

    /**
     * Create Product
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function post(Request $request)
    {

        $this->validate($request, [
            'username'   => 'required',
            'email'      => 'required|email|unique:users',
            'password'   => 'required|confirmed|min:6',
            'gender'     => 'required',
            'country'    => 'required',
            'age'        => 'required',
            'newsletter' => 'boolean',
            'role'       => 'required|exists:roles,id'
        ]);

        /**
         * Create User
         */
        dispatch(new CreateUserJob($request->except('role'), $request->get('role')));

        return redirect()->route('user.index');

    }

}