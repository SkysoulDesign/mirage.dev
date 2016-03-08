<?php

namespace App\Jobs;

use App\Models\Code;
use App\Models\Product;
use Illuminate\Support\Collection;

class GenerateCodesCommand extends Job
{

    public $queue = 'code-generator';

    /**
     * @var Collection
     */
    private $codes;

    /**
     * @var Product
     */
    private $product;

    /**
     * @var int
     */
    private $amount;

    /**
     * Create a new job instance.
     * @param $amount
     * @param Product $product
     */
    public function __construct($amount, Product $product)
    {

        $this->codes = collect();
        $this->product = $product;
        $this->amount = $amount;

    }

    /**
     * Execute the job.
     *
     * @return Collection
     */
    public function handle()
    {

        for ($i = 1; $i <= $this->amount; $i++) {
            $this->codes->push($this->generateCode());
        }

        $this->checkDatabase();

        /** @var \Illuminate\Database\Eloquent\Collection $products */
        $products = collect();

        /**
         * Now it is safe to add to the DB
         */
        $this->codes->each(function ($code) use ($products) {
            $products->push(new Code(compact('code')));
        });

        $this->product->codes()->saveMany($products);

        return $products;

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

        $generatedCode = $code->implode('-');

        /**
         * Check against itself to see if this code has been generated before
         */
        $id = $this->codes->search($generatedCode);

        if ($id)
            return $this->generateCode();

        return $generatedCode;

    }

    /**
     * Check if codes are all unique
     * @return string
     */
    private function checkDatabase()
    {

        /**
         * Check Against Database to find duplicated Code
         */
        /** @var Collection $duplicated */
        $duplicated = $this->product->codes()->whereIn('code', $this->codes->toArray())->get();

        if (!$duplicated->isEmpty()) {

            $duplicated->each(function ($duplicated) {
                $this->regenerate($duplicated->code);
            });

        }

    }

    /**
     * regenerate duplicated code
     * @return string
     */
    private function regenerate($code)
    {

        /**
         * Get Codes ID
         */
        $id = $this->codes->search($code);

        /**
         * Regenerate Code
         */
        $this->codes[$id] = $this->generateCode();

        /**
         * Check DB Again for duplication
         */
        $this->checkDatabase();

    }

}
