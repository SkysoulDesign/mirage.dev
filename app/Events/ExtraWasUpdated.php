<?php

namespace App\Events;

use App\Models\Extra;
use Illuminate\Queue\SerializesModels;

class ExtraWasUpdated extends Event
{
    use SerializesModels;

    /**
     * @var Extra
     */
    private $extra;

    /**
     * Create a new event instance.
     *
     * @param Extra $extra
     */
    public function __construct(Extra $extra)
    {
        $this->extra = $extra;
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
