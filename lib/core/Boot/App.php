<?php
/**
 * Created by PhpStorm.
 * User: eature
 * Date: 18-11-18
 * Time: 上午8:39
 */

namespace Core\Boot;

use Core\Container;
use Core\JdiException;
use Core\Router;

class App
{
    private static $config;

    private static $container;

    public static $root;

    public function __construct()
    {
        self::$root = dirname(dirname(dirname(dirname(__FILE__))));
        if (!file_exists(self::$root.'/config/env.php')) {
            throw new JdiException('No config file'. self::$root.'/config/env.php', JdiException::ERROR_EMPTY);
        }
        self::$config = require_once self::$root.'/config/env.php';
        $this->parseAndConfigEnv();
    }

    private function parseAndConfigEnv()
    {
        if (!file_exists(self::$root.'/.env')) {
            return;
        }
        $content = file_get_contents(self::$root.'/.env');
        if (empty($content)) {
            return;
        }
        $configTmp = explode(PHP_EOL, $content);
        foreach ($configTmp as $env) {
            putenv($env);
            list($key, $value) = explode('=', $env);
            self::$config[$key] = $value;
        }
        return;
    }


    public function run()
    {
        $this->init();
        Router::parse(self::$container);
    }

    private function init()
    {
        $container = new Container();
        self::$container = $container;
        $register = new ServiceRegister($container);
        $register->registerCoreService();
        $register->registerUserService();
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

    public static function getContainer()
    {
        return self::$container;
    }

}



