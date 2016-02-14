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

        $products = collect(
            [
                [
                    'name' => 'Batman Stand Version I',
                    'code' => 'MF001'
                ],
                [
                    'name' => 'Superman Stand Version I',
                    'code' => 'MF002'
                ],
                [
                    'name' => 'Worderwoman Stand Version I',
                    'code' => 'MF003'
                ],
                [
                    'name' => 'Batman (Mech Suit) Stand Version I',
                    'code' => 'MF004'
                ],
                [
                    'name' => 'Batman (Mech Suit) Stand Version II',
                    'code' => 'MF005'
                ],
                [
                    'name' => 'Batman Stand Version II',
                    'code' => 'MF006'
                ],
                [
                    'name' => 'Superman Stand Version II',
                    'code' => 'MF007'
                ],
                [
                    'name' => 'Worderwoman Stand Version I',
                    'code' => 'MF008'
                ],
                [
                    'name' => 'Doomsday Stand Version I',
                    'code' => 'MF009'
                ],
                [
                    'name' => 'Batmobile 2016 (Accelerated Mode)',
                    'code' => 'MV005'
                ],
                [
                    'name' => 'Batwing 2016 (Flying Mode)',
                    'code' => 'MV006'
                ],
                [
                    'name' => '',
                    'code' => 'MS001'
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
     * @param $code
     * @param string $ext
     * @return \Illuminate\Foundation\Application|mixed
     */
    public function file($code, $ext = 'png')
    {
        $path = base_path() . '/public/image/products/' . strtoupper($code) . '.' . $ext;
        return app(File::class, compact('path'));
    }
}
