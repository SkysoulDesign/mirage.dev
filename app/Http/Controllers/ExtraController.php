<?php

namespace App\Http\Controllers;

use App\Jobs\CreateExtraJob;
use App\Jobs\DeleteExtraJob;
use App\Jobs\UpdateExtraJob;
use App\Models\Extra;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests;
use Symfony\Component\HttpFoundation\File\File;

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
        $extra = collect();
        return view('products.extras.create', compact('product', 'extra'));
    }

    public function post(Request $request, Product $product)
    {

        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'image' => 'required|image',
            'video' => 'mimes:mp4'
        ]);

        /**
         * Create Extra
         */
        $this->dispatch(new CreateExtraJob(
            $product,
            $request->only('title', 'description'),
            $request->file('image'),
            $request->file('video')
        ));

//        return redirect()->back()->withSucess('Extra Created Successfully');
        return redirect()->route('product.extra.index', $product->id)->withSucess('Extra Created Successfully');

    }

    /* new methods for EDIT, UPDATE, DELETE 03/15/2016 */
    public function edit(Product $product, Extra $extra)
    {
        return view('products.extras.create', compact('product', 'extra'));
    }

    /**
     * @param Request $request
     * @param Product $product
     * @param Extra $extra
     * @return mixed
     */
    public function update(Request $request, Product $product, Extra $extra)
    {

        $this->validate($request, [
            'title' => 'required',
            'description' => 'required'
        ]);

        /*
         * update Extra Data of product
         */
        $this->dispatch(new UpdateExtraJob(
            $product,
            $extra,
            $request->only('title', 'description'),
            $request->file('image'),
            $request->file('video')
        ));


        return redirect()->back()->withSucess('Extra Updated Successfully');

    }

    public function delete(Product $product, Extra $extra)
    {

        $this->dispatch(new DeleteExtraJob($product, $extra));

        return redirect()->back()->withSucess('Extra Deleted Successfully');
    }

}