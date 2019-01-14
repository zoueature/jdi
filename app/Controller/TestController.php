<?php
/**
 * Created by PhpStorm.
 * User: eature
 * Date: 18-11-18
 * Time: 下午12:35
 */

namespace App\Controller;


use Core\Model;

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
        var_dump($res);
    }
}









