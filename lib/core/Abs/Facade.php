<?php
/*
 | ------------------------------
 | User: Zoueature
 | Date: 2019/4/24
 | Time: 11:57
 | ------------------------------
 */

namespace Core\Abs;


abstract class Facade
{
    protected static $instance;

    public static function __callStatic($name, $arguments)
    {
        $instance = self::getInstance();
        call_user_func_array([$instance, $name], $arguments);
    }

    private static function getInstance()
    {
        if (empty($instance)) {
            $instance = new (static ::getFactClassName());
            self::$instance = $instance;
        }
        return self::$instance;
    }

    protected abstract static function getFactClassName();
}