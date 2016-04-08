<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 * @package App\Models
 */
class Product extends Model
{

    use LocalizeModelTrait;

    /**
     * Default MySQL table
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'code', 'image'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $casts = [
        'name' => 'array', 'description' => 'array'
    ];


    /**
     * Codes Relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function codes()
    {
        return $this->hasMany(Code::class);
    }

    /**
     * Extras Relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function extras()
    {
        return $this->hasMany(Extra::class);
    }

    /**
     * Profile Relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

}
