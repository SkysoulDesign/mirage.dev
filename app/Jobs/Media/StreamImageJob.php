<?php
/**
 * Created by PhpStorm.
 * User: Vivek
 * Date: 3/21/16
 * Time: 5:48 PM
 */

namespace App\Jobs\Media;


/**
 * Class StreamImageJob
 * @package App\Jobs\Media
 */
class StreamImageJob
{

    /**
     * @var string
     */
    private $path = "";


    /**
     * StreamImageJob constructor.
     * @param $filePath
     */
    public function __construct($filePath)
    {
        $this->path = $filePath;
        $this->displayImage();

    }

    /**
     *
     */
    public function displayImage()
    {

        $this->setHeader();
        readfile($this->path);
        exit;

    }

    /**
     *
     */
    public function setHeader()
    {
        $filename = basename($this->path);
        $file_extension = strtolower(substr(strrchr($filename, "."), 1));

        switch ($file_extension) {
            case "gif":
                $type = "image/gif";
                break;
            case "png":
                $type = "image/png";
                break;
            case "jpeg":
            case "jpg":
            default:
                $type = "image/jpeg";
                break;
        }

        header('Content-type: ' . $type);
    }


}