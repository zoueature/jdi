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
        self::deal($controller, $action, $params);
    }

    public static function deal($controller, $action, $params)
    {
        $controller_relection = new \ReflectionClass($controller);
        $controller_instance = new $controller;
        $method_reflection = $controller_relection->getMethod($action);
        $dependence = $method_reflection->getParameters();
        if (empty($dependence)) {
            $method_reflection->invokeArgs($controller_instance, []);
        } else {
            foreach ($dependence as $param) {
                //获取参数名的类型指定
                $class = $param->getClass()->getName();
                if (!empty($class)) {
                    if (!class_exists($class)) {
                        throw new JdiException("Can not found class :$class");
                    }
                    $param_instance = new $class;
                    $solved[] = $param_instance;
                } else {
                    //非对象参数

                }
            }
        }
    }

    public static function setNamespace()
    {

    }
}






