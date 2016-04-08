<?php
/**
 * Created by PhpStorm.
 * User: Vivek
 * Date: 3/15/16
 * Time: 4:56 PM
 */

namespace App\Jobs\Products\Extras;

use App\Events\ExtraWasUpdated;
use App\Models\Extra;
use App\Models\Product;


class DeleteExtraJob
{

    /**
     * @var Product
     */
    private $product;

    /**
     * @var Extra
     */
    private $extra;

    /**
     * Create a new job instance.
     *
     * @param Product $product
     * @param Extra $extra
     */
    public function __construct(Product $product, Extra $extra)
    {

        $this->product = $product;
        $this->extra = $extra;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $path = '/image/products-extras/16x9/';
        unlink(base_path() . $path . $this->extra->video);
        unlink(base_path() . $this->extra->image);
        $this->extra->delete();

        /**
         * Announce ExtraWasUpdated
         */
        event(new ExtraWasUpdated($this->extra));
    }

}