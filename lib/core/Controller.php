<?php
/**
 * Created by PhpStorm.
 * User: eature
 * Date: 18-11-18
 * Time: 上午9:28
 */

namespace Core;

class Controller
{
    public function __construct()
    {

    }

    public function __destruct()
    {
        $msg = 'request data is :';
        Logger::info($msg, $_REQUEST);
        Logger::error('logger_error test ');
    }
}


