<?php

namespace App\Jobs;

use App\Events\AgeWasCreated;
use App\Models\Age;

class CreateAgeJob extends Job
{

    /**
     * @var array
     */
    private $ages;

    /**
     * Create a new job instance.
     *
     * @param array $ages
     */
    public function __construct(array $ages)
    {
        $this->ages = collect($ages);
    }

    /**
     * Execute the job.
     *
     * @param Age $age
     */
    public function handle(Age $age)
    {

        /**
         * Save all Countries
         */
        $this->ages->transform(function ($data) use ($age) {

            $e = collect(explode('/', $data));
            return $age->create(['from' => $e->first(), 'to' => $e->last()]);

        });


        /**
         * Announce CountryWasCreated
         */
        event(new AgeWasCreated($this->ages->toArray()));

    }

}
