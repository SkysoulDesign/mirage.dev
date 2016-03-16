<?php

/**
 * Created by PhpStorm.
 * User: Vivek
 * Date: 3/16/16
 * Time: 3:57 PM
 */
namespace App\Jobs\Products;

use App\Events\CodeUnlinkUpdated;
use App\Models\User;
use App\Models\Code;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * Class CodeUnlinkUserJob
 * @package App\Jobs\Products
 */
class CodeUnlinkUserJob
{
    /**
     * @var Product
     */
    private $product;
    /**
     * @var Code
     */
    private $code;

    /**
     * CodeUnlinkUserJob constructor.
     * @param Product $product
     * @param Code $code
     */
    public function __construct(Product $product, Code $code)
    {

        $this->product = $product;
        $this->code = $code;

    }

    /**
     * Execute Job
     */
    public function handle(){

        $this->code->setAttribute('user_id', null);
        $this->code->save();

        event(new CodeUnlinkUpdated($this->code));
    }
}