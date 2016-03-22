<?php

namespace App\Jobs\Products;

use App\Jobs\Job;
use Intervention\Image\ImageManager;

class EncodeImageJob extends Job
{

    /**
     * @var
     */
    private $image;

    /**
     * Create a new job instance.
     * @param $image
     */
    public function __construct($image)
    {
        $this->image = $image;
    }

    /**
     * Execute the job.
     *
     * @param ImageManager $imageManager
     * @return \Intervention\Image\Image
     * @internal param Age $age
     */
    public function handle(ImageManager $imageManager)
    {
        return $imageManager->make($this->image)->encode('data-url');
    }

}
