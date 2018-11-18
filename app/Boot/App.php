<?php
/**
 * Created by PhpStorm.
 * User: eature
 * Date: 18-11-18
 * Time: 上午8:39
 */

namespace App\Boot;

use Core\Router;

class App
{
    private static $config;

    public function __construct(Array $config)
    {
        self::$config = $config;
    }

    public function run()
    {
        Router::parse();
    }

    /**
     * ------------------------------------------------------
     * 获取配置项的值
     * @param String $key
     * -------------------------------------------------------
     */
    public static function getConfig(String $key)
    {
        if (isset(self::$config[$key])) {
            return self::$config[$key];
        }
        return NULL;
    }

    /**
     * ------------------------------------------------------
     * 设置值
     * @param String $key
     * @param $value
     * -------------------------------------------------------
     */
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



