<?php
/**
 * Created by PhpStorm.
 * User: eature
 * Date: 18-11-18
 * Time: 上午8:48
 */

function config($key, $value = '')
{
    if (empty($value) && !is_array($key)) {
        //获取配置$key的值
        return \App\Boot\App::getConfig($key);
    }
    return \App\Boot\App::setConfig($key, $value);
}