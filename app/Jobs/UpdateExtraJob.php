<?php

namespace App\Jobs;

use App\Events\ExtraWasUpdated;
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
        $extraID = $this->extra->getAttribute('id');
        $extra = $this->extra->update($this->data);

        $extra = Extra::find($extraID);
        /**
         * Move Extra Content to folder
         */
        $path = '/image/products-extras/';

        $productCode = $this->product->getAttribute('code');

        //dd($this->image);
        if ($this->image != '') {
            $imagename = $productCode . '-extra-image-' . $extraID . '.' . $this->image->guessExtension();
            $image = $this->image->move(public_path() . $path, $imagename);

            $extra->setAttribute('image', $path . $imagename);
        }

        if ($this->video != '') {
            $videoname = $productCode . '-extra-video-' . $extraID . '.' . $this->video->guessExtension();
            $video = $this->video->move(public_path() . $path, $videoname);

            $extra->setAttribute('video', $path . $videoname);
        }

        $extra->save();

        /**
         * Announce ExtraWasUpdated
         */
        event(new ExtraWasUpdated($extra));

    }

}
