<?php
/* -------------------------------------------------
 | Author: Zoueature
 | Email: zoueature@gmail.com
 | Date: 19-5-11
 | Description: 
 | -------------------------------------------------
 */


namespace App\Middleware;


use Core\Middleware;

class TestMiddleware extends Middleware
{
    public function before()
    {
        echo 123;
    }

    public function after()
    {
        echo 456;
    }
}