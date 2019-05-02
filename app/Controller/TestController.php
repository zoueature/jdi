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
        $model = new Model('book', 't_');
        $res = $model->getByPrimary(1);
        var_dump($res);die;
    }
}









