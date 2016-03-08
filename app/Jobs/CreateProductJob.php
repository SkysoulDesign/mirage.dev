<?php

namespace App\Jobs;

use App\Events\ProductWasCreated;
use App\Models\Product;
use App\Models\Profile;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\File\File;

class CreateProductJob
{

    /**
     * @var Collection
     */
    private $request;

    /**
     * @var File
     */
    private $image;

    /**
     * Create a new job instance.
     *
     * @param array $request
     * @param File  $image
     */
    public function __construct(array $request, File $image)
    {
        $this->request = collect($request);
        $this->image = $image;
    }

    /**
     * Execute the job.
     *
     * @param Product $product
     * @param Profile $profile
     */
    public function handle(Product $product, Profile $profile)
    {

        $extension = $this->image->guessExtension();
        $code = strtoupper($this->request->get('code'));

        $path = '/image/products/';
        $fileName = $code . '.' . $extension;
        $image = $this->image->move(public_path() . $path, $fileName);

        /**
         * Create Product
         */
        $product = $product->create([
            'name'  => $this->request->get('name'),
            'code'  => $code,
            'image' => $path . $fileName,
        ]);

        /**
         * Create Product Profile
         */
        $product->profile()->create([
            'description' => $this->request->get('profile_description'),
            'image'       => $path . $fileName,
        ]);

        /**
         * Announce ProductWasCreated
         */
        event(new ProductWasCreated($product));

    }

}
