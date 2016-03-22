<?php

namespace App\Jobs\Api\Products;

use App\Jobs\Job;
use App\Models\Code;
use App\Models\User;

class RegisterProductJob extends Job
{

    /**
     * @var
     */
    private $code;

    /**
     * @var User
     */
    private $user;

    /**
     * Create a new job instance.
     *
     * @param $code
     * @param User $user
     */
    public function __construct($code, User $user)
    {
        $this->code = $code;
//        $this->code = substr($code, 0, 5).'-'. implode('-', str_split(substr($code, 5, 17), 4));
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @param Code $code
     * @return bool
     */
    public function handle(Code $code)
    {

        /** @var Code $result */
        $result = $code->whereCode($this->code)->firstOrFail();

        /**
         * Check if already there is an user associated with this code
         */
        if ($result->user) return false;

        $result->setAttribute('status', true);
        $result->user()->associate($this->user);
        $result->save();

        return true;

    }

}
