<?php
/**
 * Created by PhpStorm.
 * User: Vivek
 * Date: 3/18/16
 * Time: 3:35 PM
 */

namespace App\Http\Controllers;

use App\Jobs\Media\StreamImageJob;
use App\Jobs\Media\StreamVideoJob;
use App\Models\Code;
use App\Models\Extra;
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
     * @var mixed
     */
    private $media_type;
    /**
     * @var
     */
    private $dataArr;
    /**
     * @var
     */
    private $hashDecrypt;
    /**
     * @var
     */
    private $user_id;

    /**
     * MediaController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {

        $this->middleware('auth');// to allow the url when user logged in

        $this->media_type = $request->media_type;
        $this->hashfile = $request->hashkey;

        $this->filepath = '';
        if (@$this->media_type == '')
            $this->filepath = decrypt($this->hashfile);
        $this->publicpath = public_path();
        //$this->user_id = auth()->user()->id;

    }

    /**
     * 03/21/2016
     * common function to analyze and show media
     */
    public function streamData()
    {

        $this->user_id = auth()->user()->id;
        $this->hashDecrypt = decrypt($this->hashfile);
        $this->dataArr = explode(';;;', $this->hashDecrypt);

        switch ($this->dataArr[0]) {
            case 'code':
                $code = Code::find($this->dataArr[1]);
                if ($this->user_id == $code->user_id) {
                    $extra = Extra::find($this->dataArr[2]);
                    if ($this->media_type == 'video')
                        $this->filepath = @$extra->video;
                    else
                        $this->filepath = $code->product->profile->image;
                } else
                    exit('Access Denied');
                break;
            case 'path':
                $this->filepath = @$this->dataArr[1];
                break;
            default:
                exit('Invalid data');
                break;
        }

        switch ($this->media_type) {
            case 'video':
                $this->streamVideo();
                break;
            case 'image':
                $this->showImage();
                break;
            default:
                break;
        }
        exit;

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
     * to stream images online
     */
    public function showImage()
    {

        new StreamImageJob($this->getRealPath($this->filepath));
        exit;
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