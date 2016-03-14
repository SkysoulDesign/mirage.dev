<?php

use App\Jobs\CreateProductJob;
use Illuminate\Database\Seeder;
use Symfony\Component\HttpFoundation\File\File;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $description = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.";

        $products = collect(
            [
                [
                    'name'        => 'Batman Stand Version I',
                    'code'        => 'MF001',
                    'description' => $description,
                ],
                [
                    'name'        => 'Superman Stand Version I',
                    'code'        => 'MF002',
                    'description' => $description,
                ],
                [
                    'name'        => 'Worderwoman Stand Version I',
                    'code'        => 'MF003',
                    'description' => $description,
                ],
                [
                    'name'        => 'Batman (Mech Suit) Stand Version I',
                    'code'        => 'MF004',
                    'description' => $description,
                ],
                [
                    'name'        => 'Batman (Mech Suit) Stand Version II',
                    'code'        => 'MF005',
                    'description' => $description,
                ],
                [
                    'name'        => 'Batman Stand Version II',
                    'code'        => 'MF006',
                    'description' => $description,
                ],
                [
                    'name'        => 'Superman Stand Version II',
                    'code'        => 'MF007',
                    'description' => $description,
                ],
                [
                    'name'        => 'Worderwoman Stand Version I',
                    'code'        => 'MF008',
                    'description' => $description,
                ],
                [
                    'name'        => 'Doomsday Stand Version I',
                    'code'        => 'MF009',
                    'description' => $description,
                ],
                [
                    'name'        => 'Batmobile 2016 (Accelerated Mode)',
                    'code'        => 'MV005',
                    'description' => $description,
                ],
                [
                    'name'        => 'Batwing 2016 (Flying Mode)',
                    'code'        => 'MV006',
                    'description' => $description,
                ],
                [
                    'name'        => 'Special Edition',
                    'code'        => 'MS001',
                    'description' => $description,
                ]
            ]);

        /**
         * Create all products
         */
        $products->each(function ($product) {

            $product = collect($product);

            dispatch(new CreateProductJob(
                $product->toArray(),
                $this->file($product->get('code'), '/public/image/products/', 'figurine'),
                $this->file($product->get('code'), '/public/image/products/', 'poster')
            ));

        });

    }

    /**
     * Get file in the system
     *
     * @param string $code
     * @param string $ext
     * @return \Illuminate\Foundation\Application|mixed
     */
    public function file($code, $path, $prefix = '', $ext = 'png')
    {
        $path = base_path() . $path . strtoupper($code) . '-' . $prefix . '.' . $ext;

        return app(File::class, compact('path'));
    }
}
