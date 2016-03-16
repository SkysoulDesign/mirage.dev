<?php

namespace App\Http\Controllers;

use App\Jobs\ExportProductCodesToExcelJob;
use App\Jobs\GenerateCodeCommand;
use App\Jobs\GenerateCodesCommand;
use App\Jobs\Products\CodeUnlinkUserJob;
use App\Models\Code;
use App\Models\Product;
use Illuminate\Http\Request;

/**
 * Class CodeController
 * @package App\Http\Controllers
 */
class CodeController extends Controller
{

    /**
     * @var Product
     */
    private $product;

    /**
     * CodeController constructor.
     * @param Product $product
     */
    function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Display Generator Page
     * @param $product_id
     * @return $this
     */
    public function index($product_id)
    {
        $product = $this->product->findOrFail($product_id);
        return view('products.codes.index', compact('product'))->with('codes', $product->codes()->simplePaginate());
    }

    /**
     * Display Generator Page
     * @param Product $product
     * @return $this
     */
    public function create(Product $product)
    {
        return view('products.codes.create', compact('product'));
    }

    /**
     * Display Generator Page
     * @param Request $request
     * @param Product $product
     * @return $this
     */
    public function post(Request $request, Product $product)
    {

        $this->validate($request, [
            'amount' => 'required'
        ]);

        $amount = $request->get('amount');
        $collection = collect();

        for ($i = 1; $i <= $amount; $i++) {
            $collection->push(dispatch(new GenerateCodesCommand(1, $product)));
        }

        if ($request->has('export')) {
            dispatch(new ExportProductCodesToExcelJob($product, $collection->collapse()->transform(function ($code) {
                return ['code' => $code->code];
            })));
        }

//        for ($i = 1; $i <= sqrt($amount); $i++) {
//            $codes = dispatch(new GenerateCodesCommand(sqrt($amount), $product));
//            $collection->push($codes);
//        }

        return redirect()->route('product.code.index', $product);

    }

    /**
     * Export to Excel
     * @param $product_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function export($product_id)
    {

        dispatch(new ExportProductCodesToExcelJob(app(Product::class)->findOrFail($product_id)));
        return redirect()->route('products');

    }

    /**
     * 03/16/2016
     * @param Product $product
     * @param Code $code
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeUser(Product $product, Code $code)
    {

        dispatch(new CodeUnlinkUserJob($product, $code));

        return redirect()->route('product.code.index', $product)->withSuccess('User removed from Code successfully');

    }

}