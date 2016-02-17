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
         * Create Admin
         */
        $request = [
            'username' => 'mirage',
            'email'    => 'test@mirage.com',
            'password' => '123456'
        ];

        dispatch(new CreateUserJob($request, 'user', 46));
    }
}
