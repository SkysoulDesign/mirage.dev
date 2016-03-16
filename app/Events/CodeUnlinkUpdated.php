<?php

/**
 * Created by PhpStorm.
 * User: Vivek
 * Date: 3/16/16
 * Time: 4:04 PM
 */
namespace App\Events;

use App\Models\Code;
use Illuminate\Queue\SerializesModels;

/**
 * Class CodeUnlinkUpdated
 * @package App\Events\Products
 */
class CodeUnlinkUpdated extends Event
{
    use SerializesModels;

    /**
     * @var Code
     */
    private $code;

    /**
     * CodeUnlinkUpdated constructor.
     * @param Code $code
     */
    public function __construct(Code $code)
    {
        $this->code = $code;
    }

    /**
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }

}