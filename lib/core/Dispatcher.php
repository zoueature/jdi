<?php
/**
 * Created by PhpStorm.
 * User: eature
 * Date: 18-11-18
 * Time: 上午11:28
 */

namespace Core;


class Dispatcher
{
    private static $namespace = 'App\\Controller';
    public static $route_namespace_map = [

    ];


    public static function patcher($handle, $params, $namespace = null)
    {
        if ($handle instanceof \Closure) {
            //handle is closure, do this function
            $handle();
            exit();
        }
        $arr = explode('@', $handle);
        if (empty($arr)) {
            throw new \Exception('extra handle error, please use format "controller@action"', '404');
        }
        if (empty($namespace)) {
            $namespace = self::$namespace;
        }
        $controller = $namespace.'\\'.$arr[0];
        $action = $arr[1];
        $controller = new $controller;
        call_user_func_array([$controller, $action], $params);
    }

    public static function setNamespace()
    {

    }
}






