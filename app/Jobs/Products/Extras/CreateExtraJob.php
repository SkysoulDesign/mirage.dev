<?php

namespace App\Jobs\Products\Extras;

use App\Events\ExtraWasCreated;
use App\Jobs\Job;
use App\Models\Extra;
use App\Models\Product;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CreateExtraJob extends Job
{
    /**
     * @var Product
     */
    private $product;

    /**
     * @var array
     */
    private $data;

    /**
     * @var UploadedFile
     */
    private $image;

    /**
     * @var UploadedFile
     */
    private $video;

    /**
     * Create a new job instance.
     *
     * @param Product $product
     * @param array $data
     * @param UploadedFile $image
     * @param UploadedFile $video
     */
    public function __construct(Product $product, array $data, UploadedFile $image, UploadedFile $video)
    {

        $this->product = $product;
        $this->data = $data;
        $this->image = $image;
        $this->video = $video;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {

        /**
         * Create Extra
         * @var Extra $extra
         */
        $extra = $this->product->extras()->create($this->data);

        $aspectDir = @$this->data['aspect_ratio'] ?: '16x9';
        /**
         * Move Extra Content to folder
         */
        $path = '/image/products-extras/';
        $extraID = $extra->getAttribute('id');
        $productCode = $this->product->getAttribute('code');

        $filename = $productCode . '-extra-image-' . $extraID . '.' . $this->image->guessExtension();
        $image = $this->image->move(base_path() . $path, $filename);

        $extra->setAttribute('image', $path . $filename);

        $filename = $productCode . '-extra-video-' . $extraID . '.' . $this->video->guessExtension();
        $video = $this->video->move(base_path() . $path . $aspectDir . '/', $filename);

        $extra->setAttribute('video', $filename);
        $extra->save();

        /**
         * Announce ExtraWasCreated
         */
        event(new ExtraWasCreated($extra));

    }

}
