<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\Api\Products\RegisterProductJob;
use App\Jobs\Products\EncodeImageJob;
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
     *
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

        $code = $request->get('code');
        $code = substr($code, 0, 5) . '-' . implode('-', str_split(substr($code, 5, 17), 4));
        $request->merge(compact('code'));

        $validator = $this->getValidationFactory()->make($request->all(), [
            'code' => 'required|exists:codes,code'
        ]);

        if ($validator->fails())
            return response()->json(['error' => $validator->errors()]);

        /**
         * Associate User with The Product
         */
        $response = dispatch(new RegisterProductJob($request->code, $request->user('api')));

        if (!$response)
            return response()->json(['error' => 'code_has_been_taken']);

        return response()->json(['status' => 'okay']);

    }

    /**
     * Display Generator Page
     *
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
            $product->setAttribute('image', dispatch(new EncodeImageJob(substr($product->getAttribute('image'), 1))));
        }

        return response()->json($product->load('extras', 'profile'));

    }

}