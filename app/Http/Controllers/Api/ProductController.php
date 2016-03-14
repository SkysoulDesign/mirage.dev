<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\EncodeImageJob;
use App\Jobs\RegisterProductJob;
use App\Models\Code;
use App\Models\Product;
use Illuminate\Http\Request;

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
        $this->middleware('api');
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
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function register(Request $request)
    {

        $validator = $this->getValidationFactory()->make($request->all(), [
            'code' => 'required|exists:codes,code'
        ]);

        if ($validator->fails())
            return response()->json(['error' => $validator->errors()]);

        /**
         * Associate User with The Product
         */
        $response = dispatch(new RegisterProductJob($request->get('code'), $request->user('api')));

        if (!$response)
            return response()->json(['error' => 'code_has_been_taken']);

        return response()->json(['status' => 'okay']);

    }

    /**
     * Display Generator Page
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(Request $request)
    {

        /** @var $product Product */
        if (!$product = $this->product->whereCode($request->get('product_id'))->orWhere('id', $request->get('product_id'))->first())
            return response()->json(['error' => 'invalid_code']);

        /**
         * Encode Image if necessary
         */
        if (filter_var($request->get('encode_image', false), FILTER_VALIDATE_BOOLEAN) === true) {
            $encoded = dispatch(new EncodeImageJob(substr($product->getAttribute('image'), 1)));
            $product->setAttribute('image', $encoded);
        }

        return response()->json($product->load('extras', 'profile'));

    }

}