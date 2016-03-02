<?php

namespace App\Http\Controllers;

use App\Jobs\CreateExtraJob;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests;

class ExtraController extends Controller
{
    /**
     * Display all extras
     * @param Product $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Product $product)
    {
        return view('products.extras.index', compact('product'))->with('extras', $product->extras);
    }

    public function create(Product $product)
    {
        return view('products.extras.create', compact('product'));
    }

    public function post(Request $request, Product $product)
    {

        $this->validate($request, [
            'title'       => 'required',
            'description' => 'required',
            'image'       => 'required|image',
            'video'       => 'mimes:mp4'
        ]);

        /**
         * Create Extra
         */
        dispatch(new CreateExtraJob(
            $product,
            $request->only('title', 'description'),
            $request->file('image'),
            $request->file('video')
        ));

        return redirect()->back()->withSucess('Extra Created Successfully');

    }

}