<?php

namespace App\Jobs\Roles;

use App\Events\RoleWasCreated;
use App\Jobs\Job;
use App\Models\Role;

class CreateRolesJob extends Job
{
    /**
     * @var string|array
     */
    private $name;

    /**
     * Create a new job instance.
     * @param $name |$names:array
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Execute the job.
     *
     * @param Role $roles
     */
    public function handle(Role $roles)
    {

        /**
         * if it's an array with values call itself recursively
         */
        if (is_array($this->name)) {

            foreach ($this->name as $name)
                dispatch(new self($name));

            return;

        }

        $role = $roles->create([
            'name' => $this->name
        ]);

        /**
         * Announce Role was Created
         */
        event(new RoleWasCreated($role));

    }

}
