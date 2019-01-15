<?php
/**
 * Created by PhpStorm.
 * User: eature
 * Date: 18-11-18
 * Time: 下午12:35
 */

namespace App\Controller;


use Core\Cache;
use Core\Container;
use Core\Model;
use Core\Redis;

class TestController
{
    public function index($id)
    {
        echo $id;
    }
    public function test()
    {
        $model = new Model('t_ticket_order');
        $res = $model->select();
        $container = new Container();
        $container->bind(Redis::class, Redis::class);
        $container->bind(Cache::class, Cache::class);
        $cache = $container->make(Cache::class);
        var_dump($cache);
    }
}









