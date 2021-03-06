<?php
/**
 * Created by PhpStorm.
 * User: Vivek
 * Date: 3/18/16
 * Time: 3:35 PM
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\InjectProductTrait;
use App\Jobs\Media\StreamImageJob;
use App\Models\Extra;
use Illuminate\Http\Request;

/**
 * Class MediaController
 *
 * @package App\Http\Controllers\Api
 * to stream media files online, etc and hide the absolute path
 */
class MediaController extends Controller
{
    use InjectProductTrait;
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
     * @var
     */
    private $user;
    /**
     * @var string
     */
    private $extra_path;

    /**
     * MediaController constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {

        $this->extra_path = '/image/products-extras/';

        if ($request->has('api_token')) {
            $this->middleware('api');
        } else {
            $this->middleware('auth');// to allow the url when user logged in

            $this->media_type = $request->media_type;
            $this->hashfile = $request->hashkey;

            $this->filepath = '';
            if (@$this->media_type == '' && $request->route()->getName() != 'image.path')
                $this->filepath = decrypt($this->hashfile);
        }
        $this->publicpath = base_path();
        //$this->user_id = auth()->user()->id;

    }

    /**
     * @param $type
     * @return \Illuminate\Http\JsonResponse
     */
    public function throwError($type)
    {
        $error = 'Access Denied';
        if ($type == 'json')
            $error = json_encode(['error' => $error]);

        exit($error);
    }

    /**
     *
     */
    public function showImageByPath()
    {
        $this->filepath = '/image/products-extras/' . $this->hashfile;

        return $this->showImage();
    }

    /**
     * streamVideoApi
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @internal param Extra $extra
     */
    public function streamVideoApi(Request $request)
    {

        $this->user = $request->user('api');
        $this->getProductVideoPath($request->get('extra'), 'json', $request->get('aspect', ''));

        return $this->streamVideo();

    }

    /**
     * @param $extraId
     * @param string $errorType
     * @param string $aspect
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getProductVideoPath($extraId, $errorType = '', $aspect = '')
    {
        $aspect = $aspect ?: '16x9';
        if (!is_dir($this->publicpath . $this->extra_path . $aspect))
            $aspect = '16x9';
        $codes = $this->getUserCodes($extraId, $errorType);
        $extra = Extra::find($extraId);
        $this->filepath = $this->extra_path . $aspect . '/' . @$extra->video;

        return $codes;
    }

    /**
     * @param $extraId
     * @param $errorType
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getUserCodes($extraId, $errorType = '')
    {
        /**
         * Hack the world
         */
//
        $this->adminFunction($this->user);

        return $this->user->codes;

        $user = $this->user->load('codes');

        if ($this->user->is('admin'))
            return $user->getRelation('codes');

        $this->injectProductCombo($user);

        $codes = $user->codes->load(
            ['product' => function ($query) use ($extraId) {
                $query->whereHas('extras', function ($query) use ($extraId) {
                    $query->where('id', $extraId);
                });
            }
                , 'product.profile']
        )->filter(function ($value) {
            return $value->product ?: false;
        });
        if (!$codes->first()) /** @var TYPE_NAME $this */
            $this->throwError($errorType);

        return $codes;
    }

    /**
     * 03/21/2016
     * common function to analyze and show media
     */
    public function streamData()
    {

        $this->user = auth()->user();
        $this->hashDecrypt = decrypt($this->hashfile);
        $this->dataArr = explode(';;;', $this->hashDecrypt);

        switch ($this->dataArr[0]) {
            case 'code':
                $codes = $this->getProductVideoPath($this->dataArr[2]);
                if ($this->media_type == 'video')
                    $this->getProductVideoPath($this->dataArr[2]);
                else
                    $this->filepath = @$codes[0]->product->profile->image;
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
                return $this->streamVideo();
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

        $size = \Storage::size($this->getRealPath($this->filepath));
        $file = \Storage::get($this->getRealPath($this->filepath));
        $stream = fopen($this->getRealPath($this->filepath), "r");

        $type = 'video/mp4';
        $start = 0;
        $length = $size;
        $status = 200;

        $headers = ['Content-Type' => $type, 'Content-Length' => $size, 'Accept-Ranges' => 'bytes'];

        if (false !== $range = request()->server('HTTP_RANGE', false)) {
            list($param, $range) = explode('=', $range);
            if (strtolower(trim($param)) !== 'bytes') {
                header('HTTP/1.1 400 Invalid Request');
                exit;
            }
            list($from, $to) = explode('-', $range);
            if ($from === '') {
                $end = $size - 1;
                $start = $end - intval($from);
            } elseif ($to === '') {
                $start = intval($from);
                $end = $size - 1;
            } else {
                $start = intval($from);
                $end = intval($to);
            }
            $length = $end - $start + 1;
            $status = 206;
            $headers['Content-Range'] = sprintf('bytes %d-%d/%d', $start, $end, $size);
        }

        return response()->stream(function() use ($stream, $start, $length) {
            fseek($stream, $start, SEEK_SET);
            echo fread($stream, $length);
            fclose($stream);
        }, $status, $headers);



//        dd($this->getRealPath($this->filepath));
//        $video = new StreamVideoJob($this->getRealPath($this->filepath));
//        $video->start();
//        exit;
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
