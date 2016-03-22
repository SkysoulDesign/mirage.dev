<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Jobs\Products\CreateProductJob;
use App\Jobs\Products\UpdateProductJob;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    /**
     * Display Generator Page
     *
     * @param Product $product
     * @return $this
     */
    public function index(Product $product)
    {
        return view('products.index')->with('products', $product->all());
    }

    /**
     * Display Generator Page
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Display Generator Page
     *
     * @param ProductRequest|Request $request
     * @return \Illuminate\View\View
     */
    public function post(ProductRequest $request)
    {

        $this->dispatch(new CreateProductJob($request->all(), $request->file('image'), $request->file('poster')));

        return redirect()->route('product.index')->withSuccess('Product was created Successfully');

    }

    /**
     * Shows Edit Form
     *
     * @param Product $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Shows Edit Form
     *
     * @param Product $product
     * @param ProductRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(Product $product, ProductRequest $request)
    {

        $this->dispatch(new UpdateProductJob($product, $request->all(), $request->files));

        return redirect()->back()->withSuccess('Product was Updated Successfully');

    }

}