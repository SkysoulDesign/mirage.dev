<?php

use App\Jobs\Users\CreateUserJob;
use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /**
         * Create Admin
         */
        $request = [
            'username' => 'milewski',
            'email'    => 'rafael@skysoul.com.au',
            'password' => '478135'
        ];

        dispatch(new CreateUserJob($request, 'admin', 30));

        /**
         * Create Admin
         */
        $request = [
            'username' => 'mirage',
            'email'    => 'admin@soapstudio.com',
            'password' => 'mirage2016'
        ];

        dispatch(new CreateUserJob($request, 'admin', 45));

    }

}
