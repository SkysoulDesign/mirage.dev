<?php

namespace App\Presenters;

use App\Presenters\Exceptions\PresenterException;

trait PresentableTrait
{

    public function present()
    {

        if (!$this->presenter or !class_exists($this->presenter)) {
            throw new PresenterException('Please set the protected $presenter to your presenter path.');
        }

        return new $this->presenter($this);
    }

}