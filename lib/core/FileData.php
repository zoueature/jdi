<?php
/**
 * Created by PhpStorm.
 * User: eature
 * Date: 19-1-20
 * Time: 下午7:55
 */

namespace Core;


use App\Boot\App;

class FileData
{
    private $path;

    public function __construct()
    {
        $this->path = App::$root.'/data/';
    }

    public function setPath($path)
    {
        $this->path = $path;
    }

    public function getFileContent($file)
    {
        $file_path = $this->path.$file;
        return file_get_contents($file_path);
    }

    public function getFileContentWithArr($file)
    {
        $file_path = $this->path.$file;
        return file($file_path);
    }

}