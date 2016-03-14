<?php

namespace App\Http\Controllers\Api;

use App\Models\Age;
use App\Models\Country;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class FormController extends Controller
{

    /**
     * Return all countries
     *
     * @param Country $country
     * @return \Illuminate\Http\JsonResponse
     */
    public function countries(Country $country)
    {
        return response()->json($country->all());
    }

    /**
     * Return all ages
     *
     * @param Age $age
     * @return \Illuminate\Http\JsonResponse
     */
    public function ages(Age $age)
    {
        return response()->json($age->all());
    }

}
