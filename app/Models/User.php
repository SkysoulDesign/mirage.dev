<?php

namespace App\Models;

use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'gender', 'age', 'newsletter',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Hash the Password Before Saving
     *
     * @param $password
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = app(Hasher::class)->make($password);
    }

    /**
     * Role Relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    /**
     * Country Relationship
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Codes Relationship
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function codes()
    {
        return $this->hasMany(Code::class);
    }

    /**
     * Age Relationship
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function age()
    {
        return $this->belongsTo(Age::class);
    }

    public function scopeWithProduct($query)
    {
        return $query->with(['codes' => function ($query) {
            $query->with(['product' => function ($query) {
                $query->select('id', 'name', 'code');
            }])->select('product_id', 'user_id', 'code');
        }]);
    }

    /**
     * @param $roleName
     * @return bool
     */
    public function is($roleName)
    {
        foreach ($this->roles()->get() as $role) {
            if ($role->name == $roleName) {
                return true;
            }
        }
        return false;
    }

}
