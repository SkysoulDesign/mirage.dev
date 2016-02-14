<?php

namespace App\Events;

use App\Models\Role;
use Illuminate\Queue\SerializesModels;

class RoleWasCreated extends Event
{
    use SerializesModels;

    /**
     * @var Role
     */
    private $roles;

    /**
     * Create a new event instance.
     * @param Role $roles
     */
    public function __construct(Role $roles)
    {
        $this->roles = $roles;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }

}
