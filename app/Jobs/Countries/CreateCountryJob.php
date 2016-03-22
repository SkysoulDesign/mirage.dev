<?php

namespace App\Jobs\Countries;

use App\Events\CountryWasCreated;
use App\Jobs\Job;
use App\Models\Country;

class CreateCountryJob extends Job
{

    /**
     * @var array
     */
    private $countries;

    /**
     * Create a new job instance.
     *
     * @param array $countries
     */
    public function __construct(array $countries)
    {
        $this->countries = collect($countries);
    }

    /**
     * Execute the job.
     *
     * @param Country $country
     */
    public function handle(Country $country)
    {

        /**
         * Save all Countries
         */
        $this->countries->transform(function ($name, $code) use ($country) {
            return $country->create(compact('name', 'code'));
        });

        /**
         * Announce CountryWasCreated
         */
        event(new CountryWasCreated($this->countries->toArray()));

    }

}
