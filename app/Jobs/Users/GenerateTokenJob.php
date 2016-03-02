<?php

namespace App\Jobs\Users;

use App\Models\User;
use Carbon\Carbon;
use Firebase\JWT\JWT;

class GenerateTokenJob
{

    /**
     * @var User
     */
    private $user;

    /**
     * @var bool
     */
    private $saveToken;

    /**
     * Create a new job instance.
     * @param User $user
     * @param bool $saveToken
     */
    public function __construct(User $user, $saveToken = false)
    {
        $this->user = $user;
        $this->saveToken = $saveToken;
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

        $timestamp = $carbon->now()->timestamp;
        $data = collect($this->user->toArray())->only('id')->merge(compact('timestamp'));

        $token = $jwt->encode($data, env('APP_KEY'));

        /**
         * Save token on the user model
         */
        if ($this->saveToken) {
            $this->user->setAttribute('api_token', $token);
            $this->user->save();
        }

        return $token;

    }

}