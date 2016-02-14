<?php

namespace App\Jobs\Users;

use App\Models\User;
use Carbon\Carbon;
use Firebase\JWT\JWT;

class GenerateTokenCommand
{

    /**
     * @var User
     */
    private $user;

    /**
     * Create a new job instance.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
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

        $this->user->setAttribute('api_token', $token);
        $this->user->save();

        return $token;

    }

}