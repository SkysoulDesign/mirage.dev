<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class AgeWasCreated extends Event
{
    use SerializesModels;

    /**
     * @var array
     */
    public $ages;

    /**
     * Create a new event instance.
     *
     * @param array $ages
     */
    public function __construct(array $ages)
    {
        $this->ages = $ages;
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
