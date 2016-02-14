<?php

namespace App\Jobs\Users;

use App\Events\UserWasCreated;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Collection;
use Tymon\JWTAuth\JWTAuth;

class CreateUserJob
{

    /**
     * @var Collection
     */
    private $request;

    /**
     * @var int|string
     */
    private $role;

    /**
     * Create a new job instance.
     * @param array $request
     * @param int|string $role
     */
    public function __construct(array $request, $role = 'user')
    {
        $this->request = $request;
        $this->role = $role;
    }

    /**
     * Execute the job.
     *
     * @param User $user
     * @param Role $role
     * @param JWTAuth $token
     * @return String
     */
    public function handle(User $user, Role $role, JWTAuth $token)
    {

        /**
         * Find Role
         */
        $role = $role->where('id', $this->role)->orWhere('name', $this->role)->firstOrFail();

        /**
         * Create User, Set Role and Token
         */
        $user = $user->create($this->request);
        $user->setAttribute('api_token', $token->fromUser($user));
        $user->roles()->attach($role);
        $user->save();

        event(new UserWasCreated($user));

        return $user->getAttribute('api_token');

    }

}
