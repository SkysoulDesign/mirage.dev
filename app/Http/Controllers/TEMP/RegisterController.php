<?php

namespace App\Http\Controllers;

use App\Jobs\Users\CreateUserJob;
use Illuminate\Http\Request;

class RegisterController extends Controller
{

    /**
     * Display Generator Page
     */
    public function index()
    {
        return view('register');
    }


}