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
use Core\Controller;
use Core\Model;
use Core\Redis;

class TestController extends Controller
{
    public function index($id)
    {
        echo $id;
    }
    public function test(Redis $redis, $o = 11)
    {
        $model = new Model('user', 'jingyu');
        $res = $model->select();
        var_dump($res);die;
        $container = new Container();
        $container->bind(Redis::class, Redis::class);
        $container->bind(Cache::class, Cache::class);
        $cache = $container->make(Cache::class);
        var_dump($cache);
        var_dump($redis);
    }
}









