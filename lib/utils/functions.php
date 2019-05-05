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
        return \Core\Boot\App::getConfig($key);
    }
    return \Core\Boot\App::setConfig($key, $value);
}

/* ----------------------------------
 * 获取一个对象
 * ----------------------------------
 */
function make($class)
{
    $container = \Core\Boot\App::getContainer();
    $instance = $container->make($class);
    return $instance;
}

/* ----------------------------------
 * 绑定一个类和生成方法到容器
 * ----------------------------------
 */
function bind($name, $method)
{
    $container = \Core\Boot\App::getContainer();
    return $container->bind($name, $method);
}

/* ----------------------------------
 * 获取配置
 * ----------------------------------
 */
function env(string $key, $default = null)
{
    $value = getenv($key);
    switch (strtolower($value)) {
        case 'true':
        case '(true)':
            return true;
        case 'false':
        case '(false)':
            return false;
        case 'empty':
        case '(empty)':
            return '';
        case 'null':
        case '(null)':
            return null;
    }
    return $value;
}