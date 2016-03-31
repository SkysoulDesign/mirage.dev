<?php

/**
 * Created by PhpStorm.
 * User: Vivek
 * Date: 3/18/16
 * Time: 1:57 PM
 */
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\InjectProductTrait;
use App\Http\Requests;
use App\Http\Requests\RegisterProductRequest;
use App\Jobs\Api\Products\RegisterProductJob;
use App\Models\Code;
use Illuminate\Http\Request;

/**
 * Class UserWebController
 * @package App\Http\Controllers\Web
 */
class UserWebController extends Controller
{

    use InjectProductTrait;

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
        $this->user = auth()->user();//User::find(auth()->user()->id);
    }

    /**
     * to list the product codes
     * @return $this
     * @internal param Code $code
     * @internal param User $user
     */
    public function index()
    {

        /**
         * inject product combination if not admin
         */
        $user = $this->user->load('codes', 'codes.product', 'codes.product.extras', 'codes.product.profile');
        $this->injectProductCombo($user);

        return view('web.index')->with('codes', $user->codes);
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