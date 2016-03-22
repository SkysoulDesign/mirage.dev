<?php

namespace App\Jobs;

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
     * @internal param null $user
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /*
        if (!empty($this->user)) {
            if ($this->user->id) {
                $userObj = $this->user;

                Mail::send('emails.resetpassword', array('user' => $userObj), function ($message) use ($userObj) {
                    $message->from('admin@soapstudio.com', 'Mirage Admin')
                        ->to($userObj->email)
                        ->subject('Reset Your Account Password');
                });
                return true;

            }

        }
        return false;
        */
        $broker = $this->getBroker();

        $response = Password::broker($broker)->sendResetLink(['email' => $this->request->get('user_email', '')], function (Message $message) {
            $message->from('admin@soapstudio.com');
            $message->subject($this->getEmailSubject());
        });
        //die($response.'--'.($response == 'passwords.sent' ? true : false));

        return ($response == 'passwords.sent' ? true : false);
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
