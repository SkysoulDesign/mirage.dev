<?php
/**
 * Created by PhpStorm.
 * User: Vivek
 * Date: 3/16/16
 * Time: 1:43 PM
 */

namespace App\Jobs\Users;

use App\Events\UserWasUpdated;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;


class UpdateUserJob
{

    /**
     * @var User
     */
    private $user;

    /**
     * @var array
     */
    private $data;

    /**
     * @var array
     */
    private $association;

    /**
     * Create a new job instance.
     * @param User $user
     * @param array $data
     * @param array $association
     */
    public function __construct(User $user, array $data, array $association)
    {

        $this->user = $user;
        $this->data = collect($data);
        $this->association = collect($association);
    }

    /**
     * Execute the job.
     * @return String
     * @internal param Role $role
     */
    public function handle()
    {

        $this->user->update($this->data->except('newsletter')->toArray());
        $this->user->setAttribute('newsletter', filter_var($this->data->get('newsletter', false), FILTER_VALIDATE_BOOLEAN));

        foreach ($this->association as $key => $value) {
            if ($value != '') {
                if ($key == 'role_id') {
                    $this->user->roles()->sync(array($value));
                } else {
                    $this->user->setAttribute($key, $value);
                }
            }
        }

        $this->user->save();

        event(new UserWasUpdated($this->user));

        return $this->user;
    }

}