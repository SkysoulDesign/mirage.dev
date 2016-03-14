<?php

namespace App\Events;

use App\Models\Help;
use Illuminate\Queue\SerializesModels;

class APIHelpWasCreated extends Event
{
    use SerializesModels;

    /**
     * @var Help
     */
    public $help;

    /**
     * Create a new event instance.
     *
     * @param Help $help
     */
    public function __construct(Help $help)
    {
        $this->help = $help;
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
