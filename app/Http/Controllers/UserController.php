<?php

namespace App\Http\Controllers;

use App\Jobs\Users\CreateUserJob;
use App\Jobs\Users\UpdateUserJob;
use App\Models\Age;
use App\Models\Country;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Class UserController
 *
 * @package App\Http\Controllers
 */
class UserController extends Controller
{

    /**
     * Display Generator Page
     *
     * @param User $user
     * @return $this
     */
    public function index(User $user)
    {
        return view('users.index')->with('users', $user->all());
    }

    /**
     * Create user
     *
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
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function post(Request $request)
    {

        $this->validate($request, [
            'username' => 'required|alpha_dash',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
            'gender' => 'string',
            'age_id' => 'exists:ages,id',
            'terms' => 'required|accepted',
            'role_id' => 'required|exists:roles,id',
            'country_id' => 'required|exists:countries,id',
        ]);

        /**
         * Create User
         */
        dispatch(new CreateUserJob($request->except('role_id'), $request->get('role_id'), $request->get('country_id'), $request->get('age_id')));

        return redirect()->route('user.index');

    }

    /**
     * Edit User
     *
     * @param User $user
     * @param Role $role
     * @param Country $country
     * @param Age $age
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(User $user, Role $role, Country $country, Age $age)
    {
        return view('users.edit', compact('user'))
            ->with('roles', $role->all())
            ->with('countries', $country->all())
            ->with('ages', $age->all());

    }

    /**
     * Update User
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {

        $update = ($user && $user->email === $request->get('email')) ? ',id,' . $user->id : '';

        $this->validate($request, [
            'username' => 'required|alpha_dash',
            'email' => 'required|email|unique:users' . $update,
            'password' => 'sometimes|confirmed|min:6',
            'gender' => 'string',
            'age_id' => 'exists:ages,id',
            'terms' => 'required|accepted',
            'role_id' => 'required|exists:roles,id',
            'country_id' => 'required|exists:countries,id',
        ]);

        /**
         * Update User
         */
        dispatch(
            new UpdateUserJob(
                $user,
                $request->only('username', 'password', 'email', 'gender', 'newsletter'),
                $request->only('role_id', 'country_id', 'age_id')
            )
        );

        return redirect()->route('user.edit', $user->id)->withSuccess('User updated successfully');

    }

    /**
     * Reset Password to User
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resetPassword()
    {
        return redirect()->route('user.index');
    }

    /**
     * @param User $user
     * @return $this
     */
    public function userCodes(User $user)
    {
        $codes = $user->codes;
        $view = view('products.codes.index', compact('user', 'codes'));
        if (empty($codes->toArray()))
            $view->withErrors(empty($codes->toArray()) ? 'No Codes Found' : '');
        return $view;
    }

}