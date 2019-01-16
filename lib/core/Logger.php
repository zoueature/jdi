<?php
/**
 * Created by PhpStorm.
 * User: eature
 * Date: 18-11-18
 * Time: 上午9:40
 */

namespace Core;

use Monolog\Logger as MonLogger;
use Monolog\Handler\StreamHandler;

class Logger
{
    private static $info_instance;
    private static $waring_instance;
    private static $error_instance;
    private static $sql_instance;
    private static $sql_error_instance;

    private function __construct()
    {
    }

    public static function getModel($type)
    {
        $instance = $type.'_instance';

        if (empty(self::$$instance)) {
            $log_name = config('application') ?: 'logger';
            $log_path = config('log');
            $logger_stream = $log_path.$log_name."/$type/".date('Y-m-d');
            $log = new MonLogger($log_name);
            $handle = new StreamHandler($logger_stream);
            $log->pushHandler($handle);
            self::$$instance = $log;
        }
        return self::$$instance;
    }

    public static function error(String $msg, $context = [])
    {
        self::getModel('error')->error($msg, $context);
    }

    public static function waring(String $msg, $context = [])
    {
        self::getModel('waring')->warning($msg, $context);
    }

    public static function info(string $msg, $contenxt = [])
    {
        self::getModel('info')->info($msg, $contenxt);
    }

    public static function sql(string $msg)
    {
        self::getModel('sql')->info($msg);
    }
    public static function sqlError(string $msg)
    {
        self::getModel('sql_error')->info($msg);
    }
}


