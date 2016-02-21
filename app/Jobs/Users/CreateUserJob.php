<?php

namespace App\Jobs\Users;

use App\Events\UserWasCreated;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Collection;

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
     * @var null|int
     */
    private $country_id;

    /**
     * @var null
     */
    private $age_id;

    /**
     * Create a new job instance.
     * @param array $request
     * @param int|string $role
     * @param null $country_id
     * @param null $age_id
     */
    public function __construct(array $request, $role = 'user', $country_id = null, $age_id = null)
    {
        $this->request = $request;
        $this->role = $role;
        $this->country_id = $country_id;
        $this->age_id = $age_id;
    }

    /**
     * Execute the job.
     *
     * @param User $user
     * @param Role $role
     * @return String
     */
    public function handle(User $user, Role $role)
    {

        /**
         * Find Role
         */
        $role = $role->where('id', $this->role)->orWhere('name', $this->role)->firstOrFail();

        /**
         * Create User, Set Role and Token
         */
        $user = $user->create($this->request);
        $user->setAttribute('api_token', $token = dispatch(new GenerateTokenJob($user)));
        $user->setAttribute('newsletter', filter_var(isset($this->request['newsletter']), FILTER_VALIDATE_BOOLEAN));
        $user->roles()->attach($role);
        $user->country()->associate($this->country_id);
        $user->age()->associate($this->age_id);
        $user->save();

        /**
         * Announce UserWasCreated
         */
        event(new UserWasCreated($user));

        return $user;

    }

}
