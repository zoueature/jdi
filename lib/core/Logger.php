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
    private static $access_instance;
    private static $response_instance;

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
        if (!config('log')['switch']) {
            return true;
        }
        self::getModel('error')->error($msg, $context);
    }

    public static function waring(String $msg, $context = [])
    {
        if (!config('log')['switch']) {
            return true;
        }
        self::getModel('waring')->warning($msg, $context);
    }

    public static function info(string $msg, $contenxt = [])
    {
        if (!config('log')['switch']) {
            return true;
        }
        self::getModel('info')->info($msg, $contenxt);
    }

    public static function sql(string $msg)
    {
        if (!config('log')['switch']) {
            return true;
        }
        self::getModel('sql')->info($msg);
    }
    public static function sqlError(string $msg)
    {
        if (!config('log')['switch']) {
            return true;
        }
        self::getModel('sql_error')->info($msg);
    }
    public static function access(string $msg)
    {
        if (!config('log')['switch']) {
            return true;
        }
        self::getModel('access')->info($msg);
    }
    public static function response(string $msg)
    {
        if (!config('log')['switch']) {
            return true;
        }
        self::getModel('response')->info($msg);
    }
}


