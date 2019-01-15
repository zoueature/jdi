<?php
/**
 * Created by PhpStorm.
 * User: eature
 * Date: 18-11-18
 * Time: 上午8:39
 */

namespace App\Boot;

use Core\Container;
use Core\Router;

class App
{
    private static $config;

    private static $container;

    public function __construct(Array $config)
    {
        self::$config = $config;
    }

    public function run()
    {
        $this->init();
        Router::parse();
    }

    private function init()
    {
        $container = new Container();
        $register = new Register($container);
        $register->registerCoreService();
    }


    public static function getConfig(String $key)
    {
        if (isset(self::$config[$key])) {
            return self::$config[$key];
        }
        return NULL;
    }


    public static function setConfig($key, $value)
    {
        if (is_array($key) && empty($value)) {
            self::$config = array_merge(self::$config, $key);
        } else {
            self::$config[$key] = $value;
        }
        return true;
    }


}



