<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SimpleSoftwareIO\QrCode\BaconQrCodeGenerator;

class Code extends Model
{
    /**
     * Default MySQL table
     * @var string
     */
    protected $table = 'codes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['code'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Generate QR Code
     * @return string
     */
    public function QRCode($size = 150)
    {
        /** @var  BaconQrCodeGenerator $qrCode */
        $qrCode = app(BaconQrCodeGenerator::class);
        return 'data:image/png;base64,' . base64_encode($qrCode->format('png')->size($size)->margin(0)->generate($this->code));
    }

}
