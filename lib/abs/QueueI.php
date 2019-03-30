<?php
/**
 * Created by PhpStorm.
 * User: eature
 * Date: 19-1-16
 * Time: 下午11:05
 * 队列相关接口
 */

namespace Abs;


interface QueueI
{
    public function put() :bool ;

    public function get();

    public function delete() :bool ;
}