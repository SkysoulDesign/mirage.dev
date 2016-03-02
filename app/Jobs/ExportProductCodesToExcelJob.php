<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Excel;
use SimpleSoftwareIO\QrCode\BaconQrCodeGenerator;

class ExportProductCodesToExcelJob
{

    /**
     * @var Product
     */
    private $product;

    /**
     * @var Collection
     */
    private $codes;

    /**
     * Create a new job instance.
     * @param Product $product
     * @param Collection $codes
     */
    public function __construct(Product $product, Collection $codes = null)
    {
        $this->product = $product;
        $this->codes = $codes;
    }

    /**
     * Execute the job.
     * @param Excel $excel
     */
    public function handle(Excel $excel)
    {

        $excel->create($this->product->code, function ($excel) {

            $excel->sheet($this->product->code, function ($sheet) {
                $codes = $this->codes or $this->product->codes()->get(['code']);
                $sheet->fromArray($codes);
            });

        })->download('xlsx');

    }

}
