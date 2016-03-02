<?php

use App\Jobs\CreateAgeJob;
use App\Jobs\CreateCountryJob;
use Illuminate\Database\Seeder;

class AgesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $countries = ['5/10', '15/20', '21/30', '31/40', '41/50', '51/60', '60/100'];

        dispatch(new CreateAgeJob($countries));

    }

}
