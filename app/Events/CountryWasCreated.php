<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class CountryWasCreated extends Event
{
    use SerializesModels;

    /**
     * @var array
     */
    public $countries;

    /**
     * Create a new event instance.
     *
     * @param array $countries
     */
    public function __construct(array $countries)
    {
        $this->countries = $countries;
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
