<?php

namespace App\Http\Controllers;

use App\Jobs\CreateProductJob;
use Illuminate\Http\Request;

class GeneratorController extends Controller
{

    /**
     * Display Generator Page
     */
    public function index()
    {
        return view('generator');
    }

    /**
     * Create Product
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {


    }

}