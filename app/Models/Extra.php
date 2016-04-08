<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Extra extends Model
{

    use LocalizeModelTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'extras';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'image',
    ];

    public $casts = [
        'description' => 'array', 'title' => 'array'
    ];

    /**
     * Product Relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
