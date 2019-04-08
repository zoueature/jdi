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
    }

    public function jsonReturn($errno, $msg = '', array $data = [])
    {
        $data_arr = [
            'errno' => $errno,
            'data' => $data,
            'msg' => $msg
        ];
        $json_string = json_encode($data_arr, JSON_UNESCAPED_UNICODE);
        header('Content-type: application/json');
        echo $json_string;
        $log_config = config('log');
        if ($log_config['response']) {
            Logger::response($json_string);
        }
        exit();
    }
}


