<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
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
     * @param User           $user
     * @return bool
     */
    public function handle(PasswordBroker $broker, User $user)
    {

        $field = filter_var($this->request->get('credential'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $userObj = $user->where($field, $this->request->get('credential'))->firstOrFail();

        $response = $broker->sendResetLink(['email' => $userObj->email], function (Message $message) {
            $message->from('admin@soapstudio.com');
            $message->subject($this->getEmailSubject());
        });

        return $response === $broker::RESET_LINK_SENT;

    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return string|null
     */
    public function getBroker()
    {
        return property_exists($this, 'broker') ? $this->broker : null;
    }

    /**
     * Get the e-mail subject line to be used for the reset link email.
     *
     * @return string
     */
    protected function getEmailSubject()
    {
        return property_exists($this, 'subject') ? $this->subject : 'Your Password Reset Link';
    }
}
