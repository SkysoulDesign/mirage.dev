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
            'username' => 'zhousong',
            'email'    => '123@qq.com',
            'password' => '123456',
            'gender'   => 'male'
        ];

        dispatch(new CreateUserJob($request, 'user', 45, 3));

    }

}
