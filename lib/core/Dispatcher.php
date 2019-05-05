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


    public static function patcher($handle, $params, $namespace, $container)
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
        self::deal($controller, $action, $params, $container);
    }

    public static function deal($controller, $action, $params, Container $container)
    {
        //todo 中间件处理
        $controller_relection = new \ReflectionClass($controller);
        $container->bind($controller, $controller);
        $controller_instance = $container->make($controller);
        $method_reflection = $controller_relection->getMethod($action);
        $dependence = $method_reflection->getParameters();
        if (empty($dependence)) {
            $method_reflection->invokeArgs($controller_instance, $params);
        } else {
            $params_with_instance = [];
            foreach ($dependence as $param) {
                //获取参数名的类型指定
                if (empty($param->getClass())) {
                    continue;
                }
                $class = $param->getClass()->getName();
                if (!class_exists($class)) {
                    throw new JdiException("Can not found class :$class");
                }
                $instance = $container->make($class);
                $params_with_instance[] = $instance;
            }
            $params_with_instance = array_merge($params_with_instance, $params);
            $method_reflection->invokeArgs($controller_instance, $params_with_instance);
        }
    }

    public static function setNamespace()
    {

    }
}






