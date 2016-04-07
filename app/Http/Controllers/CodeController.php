<?php

namespace App\Http\Controllers;

use App\Jobs\Products\Codes\CodeUnlinkUserJob;
use App\Jobs\Products\Codes\ExportProductCodesToExcelJob;
use App\Jobs\Products\Codes\GenerateCodesCommand;
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
     * @param $action
     * @return \Illuminate\Http\RedirectResponse
     * @internal param Request $request
     */
    public function removeUser(Product $product, Code $code, $action = null)
    {

        $user_id = $code->user_id;
        dispatch(new CodeUnlinkUserJob($product, $code));

        $successMsg = 'User removed from Code successfully';
        if (@$action == 'user')
            return redirect()->route('user.codes', $user_id)->withSuccess($successMsg);

        return redirect()->route('product.code.index', $product)->withSuccess($successMsg);

    }

}