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
            'email'    => 'rafael.milewski@gmail.com',
            'password' => '478135'
        ];

        dispatch(new CreateUserJob($request, 'admin'));

    }

}
