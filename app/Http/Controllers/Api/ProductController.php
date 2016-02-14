<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{

    /**
     * @var Product
     */
    private $product;

    /**
     * ProductController constructor.
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Display Generator Page
     *
     * @param Product $product
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Product $product)
    {
        return response()->json($product->get(['id', 'code', 'name']));
    }

    /**
     * Display Generator Page
     * @param $code
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show($code)
    {

        if (!$product = $this->product->whereCode($code)->orWhere('id', $code)->first())
            return response()->json(['error' => 'invalid_code']);

        return response()->json(collect($product)->except('updated_at', 'created_at'));

    }

}