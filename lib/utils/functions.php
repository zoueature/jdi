<?php
/**
 * Created by PhpStorm.
 * User: eature
 * Date: 18-11-18
 * Time: 上午8:48
 */

/* ---------------------------------
 * 获取或设置配置项
 * ---------------------------------
 */
function config($key, $value = '')
{
    if (empty($value) && !is_array($key)) {
        //获取配置$key的值
        return \App\Boot\App::getConfig($key);
    }
    return \App\Boot\App::setConfig($key, $value);
}

/* ----------------------------------
 * 获取一个对象
 * ----------------------------------
 */
function make($class)
{
    $container = \App\Boot\App::getContainer();
    $instance = $container->make($class);
    return $instance;
}

/* ----------------------------------
 * 绑定一个类和生成方法到容器
 * ----------------------------------
 */
function bind($name, $method)
{
    $container = \App\Boot\App::getContainer();
    return $container->bind($name, $method);
}