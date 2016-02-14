<?php

namespace App\Jobs;

use App\Events\APIHelpWasCreated;
use App\Models\Help;

class CreateAPIHelpJob extends Job
{
    /**
     * @var array
     */
    private $data;

    /**
     * Create a new job instance.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @param Help $help
     */
    public function handle(Help $help)
    {
        $help = $help->create($this->data);

        /**
         * Announce APIHelpWasCreated
         */
        event(new APIHelpWasCreated($help));

    }

}
