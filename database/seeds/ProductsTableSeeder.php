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
                    'name'                => 'Batman Stand Version I',
                    'code'                => 'MF001',
                    'profile_description' => $description,
                ],
                [
                    'name'                => 'Superman Stand Version I',
                    'code'                => 'MF002',
                    'profile_description' => $description,
                ],
                [
                    'name'                => 'Worderwoman Stand Version I',
                    'code'                => 'MF003',
                    'profile_description' => $description,
                ],
                [
                    'name'                => 'Batman (Mech Suit) Stand Version I',
                    'code'                => 'MF004',
                    'profile_description' => $description,
                ],
                [
                    'name'                => 'Batman (Mech Suit) Stand Version II',
                    'code'                => 'MF005',
                    'profile_description' => $description,
                ],
                [
                    'name'                => 'Batman Stand Version II',
                    'code'                => 'MF006',
                    'profile_description' => $description,
                ],
                [
                    'name'                => 'Superman Stand Version II',
                    'code'                => 'MF007',
                    'profile_description' => $description,
                ],
                [
                    'name'                => 'Worderwoman Stand Version I',
                    'code'                => 'MF008',
                    'profile_description' => $description,
                ],
                [
                    'name'                => 'Doomsday Stand Version I',
                    'code'                => 'MF009',
                    'profile_description' => $description,
                ],
                [
                    'name'                => 'Batmobile 2016 (Accelerated Mode)',
                    'code'                => 'MV005',
                    'profile_description' => $description,
                ],
                [
                    'name'                => 'Batwing 2016 (Flying Mode)',
                    'code'                => 'MV006',
                    'profile_description' => $description,
                ],
                [
                    'name'                => '',
                    'code'                => 'MS001',
                    'profile_description' => $description,
                ]
            ]);

        /**
         * Create all products
         */
        $products->each(function ($product) {

            $product = collect($product);
            dispatch(new CreateProductJob($product->toArray(), $this->file($product->get('code'))));

        });

    }

    /**
     * Get file in the system
     *
     * @param        $code
     * @param string $ext
     *
     * @return \Illuminate\Foundation\Application|mixed
     */
    public function file($code, $ext = 'png')
    {
        $path = base_path() . '/public/image/products/' . strtoupper($code) . '.' . $ext;
        return app(File::class, compact('path'));
    }
}
