<?php

namespace App\Jobs;

use App\Models\Code;
use App\Models\Product;
use Illuminate\Support\Collection;

class GenerateCodeCommand extends Job
{

    /**
     * Queue Name
     *
     * @var string
     */
    public $queue = 'code-generator';

    /**
     * @var Product
     */
    private $product;

    /**
     * Create a new job instance.
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Execute the job.
     *
     * @param Product $model
     * @return Collection
     */
    public function handle(Product $model)
    {

        do {

            $code = $this->generateCode();

        } while (!$model->whereCode($code)->get());

        $this->product->codes()->save(new Code(compact('code')));

    }

    /**
     * @return string
     */
    public function generateCode()
    {

        $product_code = $this->product->code;
        $product_name = $this->product->name;

        $product_secret = strtoupper(substr(md5(microtime()) . $product_code . $product_name, rand(0, 15), 5));

        $md5 = strtoupper(md5($product_secret));

        $code = collect();
        $code->push($product_code);
        $code->push(substr($md5, 5, 4));
        $code->push(substr($md5, 10, 4));
        $code->push(substr($md5, 15, 4));

        return $code->implode('-');

    }

}
