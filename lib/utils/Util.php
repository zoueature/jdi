<?php
/**
 * Created by PhpStorm.
 * User: eature
 * Date: 19-1-19
 * Time: 下午9:53
 */

namespace Utils;


class Util
{
    /* -----------------------------
     * 检查email格式
     * -----------------------------
     */
    public static function checkEmail(string $string)
    {
        $regex = '/[a-zA-Z0-9_\.]+@[a-zA-Z0-9_\.]+\.[a-zA-Z0-9_\.]+/';
        $is_email = preg_match($regex, $string);
        return $is_email;
    }

    /* -----------------------------
     * 检查手机号
     * -----------------------------
     */
    public static function checkPhone(string $string)
    {
        $regex = '/^1[0-9]{10}$/';
        $is_email = preg_match($regex, $string);
        return $is_email;
    }

    /* -----------------------------
     * 获取毫秒时间戳
     * -----------------------------
     */
    public static function getMicroTimestamp()
    {
        $microtime = microtime();
        $arr = explode(' ', $microtime);
        $microTimestamp = ($arr[0] + $arr[1]) * 1000;
        return intval($microTimestamp);
    }
}