<?php
/**
 * Created by PhpStorm.
 * User: Vivek
 * Date: 4/7/16
 * Time: 1:56 PM
 */

namespace App\Models;


trait LocalizeModelTrait
{

    public function getNameAttribute($name)
    {
        return $this->getLocalize($name);
    }

    public function getNameArrayAttribute()
    {
        return json_decode($this->getOriginal('name'), true);
    }

    public function getDescriptionAttribute($name)
    {
        return $this->getLocalize($name);
    }

    public function getDescriptionArrayAttribute()
    {
        return json_decode($this->getOriginal('description'), true);
    }

    public function getTitleAttribute($name)
    {
        return $this->getLocalize($name);
    }

    public function getTitleArrayAttribute()
    {
        return json_decode($this->getOriginal('title'), true);
    }

    public function getLocalize($json)
    {
        $array = collect(json_decode($json, true));
        $language = app()->getLocale();
        if ($array->get($language) == '')
            $language = 'en';
        return $array->get($language);

    }

}