<?php

namespace App\Models;

use App\Presenters\PresentableTrait;
use App\Presenters\Presenter;
use App\Presenters\Presenter\HelpPresenter;
use Illuminate\Database\Eloquent\Model;

class Help extends Model
{

    use PresentableTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'help';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'route', 'description',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Presenter for this class
     *
     * @var Presenter
     */
    protected $presenter = HelpPresenter::class;

}
