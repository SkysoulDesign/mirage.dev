<?php

namespace App\Jobs\Products\Extras;

use App\Events\ExtraWasUpdated;
use App\Jobs\Job;
use App\Models\Extra;
use App\Models\Product;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UpdateExtraJob extends Job
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
     * @var Extra
     */
    private $extra;

    /**
     * Create a new job instance.
     *
     * @param Product $product
     * @param Extra $extra
     * @param array $data
     * @param UploadedFile $image
     * @param UploadedFile $video
     */
    public function __construct(Product $product, Extra $extra, array $data, UploadedFile $image = null, UploadedFile $video = null)
    {
        $this->product = $product;
        $this->extra = $extra;
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
        $this->extra->update($this->data);

        $aspectDir = @$this->data['aspect_ratio'] ?: '16x9';
        /**
         * Move Extra Content to folder
         */
        $path = '/image/products-extras/';

        $productCode = $this->product->getAttribute('code');

        if ($this->image) {
            $imageName = $productCode . '-extra-image-' . $this->extra->id . '.' . $this->image->guessExtension();
            $this->image->move(base_path() . $path, $imageName);

            $this->extra->setAttribute('image', $path . $imageName);
        }

        if ($this->video) {
            $videoName = $productCode . '-extra-video-' . $this->extra->id . '.' . $this->video->guessExtension();
            $this->video->move(base_path() . $path . $aspectDir . '/', $videoName);

            $this->extra->setAttribute('video', $videoName);
        }

        $this->extra->save();

        /**
         * Announce ExtraWasUpdated
         */
        event(new ExtraWasUpdated($this->extra));

    }

}
