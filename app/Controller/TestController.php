<?php
/**
 * Created by PhpStorm.
 * User: eature
 * Date: 18-11-18
 * Time: 下午12:35
 */

namespace App\Controller;


use Core\Db\Model;
use Core\Db\Memcache;
use Core\Db\Redis;
use Core\Controller;


class TestController extends Controller
{
    public function test()
    {
        echo "<h1>Hello Jdi</h1>";
    }
}









