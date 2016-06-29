<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class MediaController
 *
 * @package App\Http\Controllers\Api
 * to stream media files online, etc and hide the absolute path
 */
class MediaControllerNew extends Controller
{

    /**
     * MediaController constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {

    }

    public function streamVideoApi(Request $request, Extra $extra)
    {
        return $this->getStreamResponse(
            $extra->find($request->input('extra')),
            $request->input('aspect')
        );
    }

    public function streamData(Request $request, Extra $extra)
    {

        $dataArr = explode(';;;', decrypt($request->route('hashkey')));

        return $this->getStreamResponse(
            $extra->find($dataArr[2])
        );

    }

    private function getVideoPath($extra_id, $aspect = '16x9')
    {

        $extra = Extra::find($extra_id);

        if (!is_dir(base_path("/image/products-extras/$aspect"))) {
            $aspect = '16x9';
        }

        return base_path("/image/products-extras/$aspect/$extra->video");
    }

    private function getStreamResponse(Extra $extra, string $aspect = '16x9')
    {

        $size = \Storage::size($path = $this->getVideoPath($extra->id, $aspect));
        $stream = fopen($path, "r");

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

        return response()->stream(function () use ($stream, $start, $length) {
            fseek($stream, $start, SEEK_SET);
            echo fread($stream, $length);
            fclose($stream);
        }, $status, $headers);
    }

}
