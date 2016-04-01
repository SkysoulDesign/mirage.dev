<?php

namespace App\Http\Controllers\Traits;

use App\Models\Product;
use App\Models\User;

/**
 * Created by PhpStorm.
 * User: Vivek
 * Date: 3/31/16
 * Time: 3:39 PM
 */
trait InjectProductTrait
{

    /**
     * injectProductCombo:
     * if it's an user, check product combination (1, 2, 3) exists and auto inject product (12)
     * also need to do in reverse
     * @param User $user
     */
    protected function injectProductCombo(User $user)
    {
        if (!$user->is('admin')) {
            $codes = $user->getRelation('codes');

            if($codes->isEmpty()) return;

            $productCombo = collect([1, 2, 3]);
            $injectProduct = collect([12]);


            /** @var Collection $prdIdArr */
            $prdIdArr = $codes->pluck('product_id')->unique()->toArray();


            $diff = $productCombo->diff($prdIdArr);
            $diffInverse = $injectProduct->diff($prdIdArr);

            $product = collect();

            if ($diff->isEmpty()) {
                $product = $diffInverse;
            } else if ($diffInverse->isEmpty()) {
                $product = $diff;
            }

            if (!$product->isEmpty()) {
                $code = $this->getCodeByProduct($product->toArray());
                if ($code) {
                    $codes = $codes->merge($code);
                }

                $user->setRelation('codes', $codes);
            }
        }
    }

    /**
     * @param $product
     * @return $this
     */
    protected function getCodeByProduct($product)
    {
        $code = Product::all()->whereIn('id', $product)->transform(function ($product) {
            /** @var Code $code */
            return $product->codes()->with('product', 'product.extras', 'product.profile')->first();
        });
        return $code;
    }
}