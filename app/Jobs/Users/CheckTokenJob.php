<?php

namespace App\Jobs\Users;

use Carbon\Carbon;
use Firebase\JWT\JWT;

class CheckTokenJob
{

    /**
     * @var string
     */
    private $token;


    /**
     * Create a new job instance.
     * @param $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Execute the job.
     *
     * @param JWT $jwt
     * @param Carbon $carbon
     * @return String
     */
    public function handle(JWT $jwt, Carbon $carbon)
    {

        $token = $jwt->decode($this->token, env('APP_KEY'), ['HS256']);

        $date = $carbon->createFromTimestamp($token->timestamp);
        $today = $carbon->now();

        /**
         * if the difference is grater than 30 days, then request login again
         */
        return $date->diffInDays($today) > 30;

    }

}