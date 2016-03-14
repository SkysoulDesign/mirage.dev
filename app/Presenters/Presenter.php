<?php

namespace App\Presenters;

use Illuminate\Database\Eloquent\Model;

abstract class Presenter
{

    /**
     * @var Model
     */
    public $model;

    /**
     * Presenter constructor.
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function __get($name)
    {

        if (method_exists($this, $name)) {

            return $this->$name();

        }

        return $this->model->$name;
    }

    public function __call($name, $params)
    {

        if (method_exists($this, $name)) {

            return $this->$name($params);

        }

        return $this->model->$name($params);
    }


}