<?php

namespace App\Http\Controllers;

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
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function post(Request $request)
    {

        $this->validate($request, [
            'name'        => 'required',
            'code'        => 'required|size:5|unique:products',
            'image'       => 'required|mimes:jpeg,png|image',
            'poster'     => 'required|mimes:jpeg,png|image',
            'description' => 'required',
        ]);

        $this->dispatch(new CreateProductJob($request->all(), $request->file('image'), $request->file('poster')));

        return redirect()->route('product.index');

    }

}