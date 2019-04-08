<?php
/**
 * Created by PhpStorm.
 * User: Zou
 * Date: 2019/1/15
 * Time: 9:27
 */

namespace Abs;

interface NoSql
{
    public function get($key);

    public function set($key, $value);
}
