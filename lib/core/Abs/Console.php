<?php
/**
 * Created by PhpStorm.
 * User: eature
 * Date: 19-1-16
 * Time: 下午11:07
 * 命令行接口
 */

namespace Core\Abs;


abstract class Console
{
    public abstract function run();

    protected function getArgv()
    {

    }
}