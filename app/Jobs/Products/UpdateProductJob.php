<?php

namespace App\Jobs\Products;

use App\Jobs\Job;
use App\Models\Product;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\FileBag;

class UpdateProductJob extends Job
{
    /**
     * @var array
     */
    private $request;

    /**
     * @var FileBag
     */
    private $files;

    /**
     * @var Product
     */
    private $product;

    /**
     * Create a new job instance.
     *
     * @param Product $product
     * @param array $request
     * @param FileBag $files
     */
    public function __construct(Product $product, array $request, FileBag $files)
    {
        $this->product = $product;
        $this->request = collect($request);
        $this->files = $files;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

//        /**
//         * Create Product
//         */
//        $product = $product->create([
//            'name'  => $this->request->get('name'),
//            'code'  => $this->request->get('code'),
//            'image' => $this->moveFile($this->image, '/image/products/', 'figurine'),
//        ]);
//
//        /**
//         * Create Product Profile
//         */
//        $product->profile()->create([
//            'description' => $this->request->get('description'),
//            'image'       => $this->moveFile($this->poster, '/image/products/', 'poster')
//        ]);


        $this->product->update([
            'name' => $this->request->get('name'),
            'code' => $this->request->get('code'),
            'image' => $this->files->has('image') ?
                $this->moveFile($this->files->get('image'), '/image/products/', 'figurine') : $this->product->image
        ]);
        dd($this->request->input('description'));
        $this->product->profile->update([
            'description' => $this->request->input('description'),
            'image' => $this->files->has('poster') ?
                $this->moveFile($this->files->get('poster'), '/image/products/', 'poster') : $this->product->profile->image
        ]);

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
