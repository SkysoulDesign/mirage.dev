<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Excel;
use SimpleSoftwareIO\QrCode\BaconQrCodeGenerator;
use Symfony\Component\HttpFoundation\File\File;

class ExportCodesToExcelCommand
{

    /**
     * @var Product
     */
    private $product;

    /**
     * Create a new job instance.
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Execute the job.
     * @param Excel $excel
     */
    public function handle(Excel $excel)
    {

        $excel->create($this->product->code, function ($excel) {

            $excel->sheet($this->product->code, function ($sheet) {
                $sheet->fromArray($this->product->codes()->get(['code'])->toArray());
            });

        })->download('xlsx');

    }

}
