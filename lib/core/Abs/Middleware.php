<?php
/* -------------------------------------------------
 | Author: Zoueature
 | Email: zoueature@gmail.com
 | Date: 19-5-11
 | Description: 中间件接口
 | -------------------------------------------------
 */


namespace Core\Abs;


interface Middleware
{
    public function before();

    public function after();
}