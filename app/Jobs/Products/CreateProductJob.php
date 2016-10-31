<?php

namespace App\Jobs\Products;

use App\Events\ProductWasCreated;
use App\Models\Product;
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
     * @var File
     */
    private $poster;

    /**
     * Create a new job instance.
     *
     * @param array $request
     * @param File $image
     * @param File $poster
     */
    public function __construct(array $request, File $image, File $poster)
    {
        $this->request = collect($request);
        $this->image = $image;
        $this->poster = $poster;
    }

    /**
     * Execute the job.
     *
     * @param Product $product
     */
    public function handle(Product $product)
    {

        /**
         * Create Product
         */
        $product = $product->create([
            'name' => $this->request->get('name'),
            'code' => $this->request->get('code'),
            'image' => $this->moveFile($this->image, '/image/products/', 'figurine'),
        ]);

        /**
         * Create Product Profile
         */
        $product->profile()->create([
            'description' => $this->request->input('description'),
            'image' => $this->moveFile($this->poster, '/image/products/', 'poster')
        ]);

        /**
         * Announce ProductWasCreated
         */
        event(new ProductWasCreated($product));

    }

    /**
     * @param File $image
     * @param string $prefix
     * @param String $path
     * @return string
     */
    public function moveFile(File $image, $path, $prefix = '')
    {

        $extension = $image->guessExtension();
        $code = strtoupper($this->request->get('code'));

        $fileName = $code . '-' . $prefix . '.' . $extension;

        $image->move(public_path() . $path, $fileName);

        return $path . $fileName;

    }

}
