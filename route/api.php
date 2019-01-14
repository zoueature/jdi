<?php
/**
 * Created by PhpStorm.
 * User: eature
 * Date: 18-11-18
 * Time: 下午12:41
 */

use Core\Router;

Router::get('/api/test', 'TestController@test', 'App\\Controller');