<?php

use App\Jobs\Roles\CreateRolesJob;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /**
         * Create Roles by giving it an array
         */
        dispatch(new CreateRolesJob([
            'admin', 'manager', 'user'
        ]));

    }
}
