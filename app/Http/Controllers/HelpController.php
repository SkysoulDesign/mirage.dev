<?php

namespace App\Http\Controllers;

use App\Jobs\CreateAPIHelpJob;
use App\Models\Help;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Route;
use Illuminate\Routing\RouteCollection;
use Illuminate\Routing\Router;

class HelpController extends Controller
{
    /**
     * Help API
     * @param Help $help
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Help $help)
    {
        return view('help.index')->with('apis', $help->all());
    }

    /**
     * Create
     * @param Router $router
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Router $router)
    {
        return view('help.create')->with('routes', $router->getRoutes()->getRoutes());
    }

    /**
     * Post
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function post(Request $request)
    {

        $this->validate($request, [
            'route'       => 'required',
            'description' => 'required'
        ]);

        /**
         * Create APIHelp
         */
        dispatch(new CreateAPIHelpJob($request->toArray()));

        return redirect()->back()->with('success', 'Api Created Successfully');
    }

}
