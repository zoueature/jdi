<?php
/**
 * Created by PhpStorm.
 * User: Zou
 * Date: 2019/1/15
 * Time: 9:35
 *
 * 注册类，提供相关服务的注册方法
 */

namespace App\Boot;


class Register
{
    private static $single = true;

    /* -----------------------------------------
     * 绑定相关类到容器中
     * -----------------------------------------
     */
    public static function bindClass($classes, $method)
    {
        if (is_array($classes)) {
            //
        } else if (is_string($classes)) {

        }
    }

    public static function setDefaultSingle(bool $single)
    {
        self::$single = $single;
    }

}