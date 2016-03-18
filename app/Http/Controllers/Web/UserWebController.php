<?php

/**
 * Created by PhpStorm.
 * User: Vivek
 * Date: 3/18/16
 * Time: 1:57 PM
 */
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\RegisterProductRequest;
use App\Jobs\RegisterProductJob;
use App\Models\Code;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Class UserWebController
 * @package App\Http\Controllers\Web
 */
class UserWebController extends Controller
{

    /**
     * @var
     */
    private $user;

    /**
     * UserWebController constructor.
     */
    public function __construct()
    {
        // to create user object
        $this->user = User::find(auth()->user()->id);
    }

    /**
     * to list the product codes
     * @return $this
     * @internal param Code $code
     * @internal param User $user
     */
    public function index()
    {
        return view('web.index')->with('codes', $this->user->codes);
    }

    /**
     * to register a product code by user
     */
    public function registerProduct()
    {

        return view('web.product.register');

    }

    /**
     * post process for register product
     * @param Request $request
     * @return $this
     */
    public function createProduct(RegisterProductRequest $request)
    {

        $response = $this->dispatch(new RegisterProductJob($request->get('code'), $request->user()));

        if (!$response)
            return redirect()->back()->withErrors(['error' => 'Code has been taken (OR) not valid']);

        return redirect()->route('web.index')->withSucess('Product registered successfully');

    }

    /**
     * @param Code $code
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @internal param Product $product
     */
    public function viewProductByCode(Code $code){

        $product = $code->product;

        return view('web.show', compact('product', 'code'))->with('extras', $product->extras);
    }

}