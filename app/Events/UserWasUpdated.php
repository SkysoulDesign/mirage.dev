<?php

/**
 * Created by PhpStorm.
 * User: Vivek
 * Date: 3/16/16
 * Time: 1:45 PM
 */
namespace App\Events;

use App\Models\User;
use Illuminate\Queue\SerializesModels;

class UserWasUpdated extends Event
{
    use SerializesModels;

    /**
     * @var User
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
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