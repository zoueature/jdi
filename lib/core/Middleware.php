<?php
/* -------------------------------------------------
 | Author: Zoueature
 | Email: zoueature@gmail.com
 | Date: 19-5-11
 | Description: 中间件
 | -------------------------------------------------
 */


namespace Core;

use Core\Abs\Middleware as MiddlewareInterface;
use Net\HttpRequest;


class Middleware implements MiddlewareInterface
{
    protected $request;

    public function __construct(HttpRequest $request)
    {
        $this->request = $request;
    }

    public function before()
    {
        // TODO: Implement before() method.
    }

    public function after()
    {
        // TODO: Implement after() method.
    }
}