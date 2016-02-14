<?php

namespace App\Http\Controllers;

use App\Jobs\ExportCodesToExcelCommand;
use App\Jobs\GenerateCodeCommand;
use App\Jobs\GenerateCodesCommand;
use App\Models\Product;
use Illuminate\Http\Request;

class CodeController extends Controller
{

    /**
     * @var Product
     */
    private $product;

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
        return view('products.codes.index', compact('product'))->with('codes', $product->codes()->paginate());
    }

    /**
     * Display Generator Page
     * @param $product_id
     * @return $this
     */
    public function create($product_id)
    {
        return view('products.codes.create')->with('product', $this->product->findOrFail($product_id));
    }

    /**
     * Display Generator Page
     * @param Request $request
     * @param $product_id
     * @return $this
     */
    public function post(Request $request, $product_id)
    {

        $this->validate($request, [
            'amount' => 'required'
        ]);

        $amount = $request->get('amount');
        $product = $this->product->findOrFail($product_id);

        for ($i = 1; $i <= sqrt($amount); $i++) {
            dispatch(new GenerateCodesCommand(sqrt($amount), $product));
        }

        return redirect()->route('product.codes', ['product' => $product_id]);

    }

    /**
     * Export to Excel
     * @param $product_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function export($product_id)
    {
        dispatch(new ExportCodesToExcelCommand(app(Product::class)->findOrFail($product_id)));
        return redirect()->route('products');

    }

}