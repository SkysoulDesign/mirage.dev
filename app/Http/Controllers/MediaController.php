<?php
/**
 * Created by PhpStorm.
 * User: Vivek
 * Date: 3/18/16
 * Time: 3:35 PM
 */

namespace App\Http\Controllers;

use App\Jobs\Media\StreamVideoJob;
use Illuminate\Http\Request;

/**
 * Class MediaController
 * @package App\Http\Controllers\Api
 * to stream media files online, etc and hide the absolute path
 */
class MediaController extends Controller
{
    /**
     * @var mixed|null
     */
    private $hashfile;
    /**
     * @var string
     */
    private $filepath;
    /**
     * @var string
     */
    private $publicpath;

    /**
     * MediaController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {

        $this->middleware('auth');// to allow the url when user logged in

        $this->hashfile = $request->hashkey;
        $this->filepath = decrypt($this->hashfile);
        $this->publicpath = public_path();

    }

    /**
     * to stream videos online
     */
    public function streamVideo()
    {

//        dd($this->getRealPath($this->filepath));
        $video = new StreamVideoJob($this->getRealPath($this->filepath));
        $video->start();
        exit;
    }

    /**
     *
     */
    public function showImage()
    {

        return '';
    }

    /**
     * @param string $file
     * @return string
     */
    public function getRealPath($file = '')
    {

        return $this->publicpath . $file;
    }
}