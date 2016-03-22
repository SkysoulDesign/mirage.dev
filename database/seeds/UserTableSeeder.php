<?php

use App\Jobs\Users\CreateUserJob;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /**
         * Create User
         */
        $request = [
            'username' => 'demo',
            'email'    => 'demo@demo.com',
            'password' => 'demo123456',
            'gender'   => 'male'
        ];

        $user = dispatch(new CreateUserJob($request, 'user', 45, 3));

//        $codes = rand(1, Code::count());
//
//        /**
//         * Buy some Products
//         */
//        dispatch(new RegisterProductJob($codes, $user));

    }

}
