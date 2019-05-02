<?php
/**
 * Created by PhpStorm.
 * User: eature
 * Date: 18-11-24
 * Time: 上午10:11
 */

namespace Core\Db;


use Core\Abs\NoSql;

class Memcache implements NoSql
{
    public function get(string $key)
    {
        // TODO: Implement get() method.
    }

    public function set(string $key, string $value)
    {
        // TODO: Implement set() method.
    }
}