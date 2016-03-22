<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\ExtraRequest;
use App\Jobs\CreateExtraJob;
use App\Jobs\DeleteExtraJob;
use App\Jobs\UpdateExtraJob;
use App\Models\Extra;
use App\Models\Product;
use Illuminate\Http\Request;

class ExtraController extends Controller
{
    /**
     * Display all extras
     *
     * @param Product $product
     * @return $this
     */
    public function index(Product $product)
    {
        return view('products.extras.index', compact('product'))->with('extras', $product->extras);
    }

    /**
     * Show Create Extras Page
     *
     * @param Product    $product
     * @param Collection $extra
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Product $product, Collection $extra)
    {
        return view('products.extras.create', compact('product', 'extra'));
    }

    /**
     * Show Product
     *
     * @param ExtraRequest $request
     * @param Product      $product
     * @return mixed
     */
    public function post(ExtraRequest $request, Product $product)
    {

        /**
         * Create Extra
         */
        $this->dispatch(new CreateExtraJob(
            $product,
            $request->only('title', 'description'),
            $request->file('image'),
            $request->file('video')
        ));

        return redirect()->route('product.extra.index', $product->id)->withSucess('Extra Created Successfully');

    }

    /**
     * New methods for EDIT, UPDATE, DELETE
     *
     * @param Product $product
     * @param Extra   $extra
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Product $product, Extra $extra)
    {
        return view('products.extras.create', compact('product', 'extra'));
    }

    /**
     * @param Request $request
     * @param Product $product
     * @param Extra   $extra
     * @return mixed
     */
    public function update(Request $request, Product $product, Extra $extra)
    {

        $this->validate($request, [
            'title'       => 'required',
            'description' => 'required'
        ]);

        /**
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

    /**
     * Delete Extra
     *
     * @param Product $product
     * @param Extra   $extra
     * @return mixed
     */
    public function delete(Product $product, Extra $extra)
    {
        $this->dispatch(new DeleteExtraJob($product, $extra));
        return redirect()->back()->withSucess('Extra Deleted Successfully');
    }

}