<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Password;

/**
 * Class ResetPasswordMailJob
 * @package App\Jobs
 */
class ResetPasswordMailJob extends Job
{
    use InteractsWithQueue, SerializesModels;
    /**
     * @var null
     */
    private $request;

    /**
     * Create a new job instance.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Execute the job.
     * @param Password $password
     * @return bool
     */
    public function handle(Password $password, User $user)
    {

        $field = filter_var($this->request->input('credential'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        //$this->request->merge([$field => $this->request->input('credential')]);

        $userObj = $user->where($field, $this->request->input('credential'))->firstOrFail();

        $broker = $this->getBroker();

        // $this->request->only('email')

        $response = $password::broker($broker)->sendResetLink(['email' => $userObj->email], function (Message $message) {
            $message->from('admin@soapstudio.com');
            $message->subject($this->getEmailSubject());
        });

        return $response === Password::RESET_LINK_SENT;

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
