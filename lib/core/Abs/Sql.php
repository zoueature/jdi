<?php
/**
 * Created by PhpStorm.
 * User: eature
 * Date: 19-1-16
 * Time: 下午11:04
 */

namespace Core\Abs;


interface Sql
{
    public function getByPr(string $id) :array ;
}