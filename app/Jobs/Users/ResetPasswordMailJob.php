<?php

namespace App\Jobs\Users;

use App\Jobs\Job;
use App\Models\User;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Message;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;


/**
 * Class ResetPasswordMailJob
 *
 * @package App\Jobs
 */
class ResetPasswordMailJob extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * Queue name
     *
     * @var string
     */
    public $queue = 'email';

    /**
     * @var null
     */
    private $request;

    /**
     * Create a new job instance.
     *
     * @param array $request
     */
    public function __construct(array $request)
    {
        $this->request = collect($request);
    }

    /**
     * Execute the job.
     *
     * @param PasswordBroker $broker
     * @param User $user
     * @return bool
     */
    public function handle(PasswordBroker $broker, User $user)
    {

        $field = filter_var($this->request->get('credential'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $userObj = $user->where($field, $this->request->get('credential'))->first();

        if($userObj) {
            $response = $broker->sendResetLink(['email' => $userObj->email], function (Message $message) {
                $message->from('admin@soapstudio.com');
                $message->subject('Your Password Reset Lin');
            });

            return $response === $broker::RESET_LINK_SENT;
        }

        return false;

    }

}
