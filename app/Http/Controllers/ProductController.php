<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Jobs\CreateProductJob;
use App\Jobs\ExportProductCodesToExcelJob;
use App\Jobs\GenerateCodesCommand;
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

        return redirect()->route('product.index');

    }

}