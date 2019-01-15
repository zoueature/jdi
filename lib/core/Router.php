<?php
/**
 * Created by PhpStorm.
 * User: eature
 * Date: 18-11-18
 * Time: 上午10:19
 */

namespace Core;


use FastRoute\DataGenerator\GroupCountBased;
use FastRoute\Dispatcher\GroupCountBased as FastDispatcher;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use FastRoute\RouteParser\Std;
use Core\Dispatcher as CPatcher;

class Router
{
    private static $route;
    private static $dispatcher;
    private static $namesapce = [];

    public static function init()
    {
        //初始化一个路由集合
        if (empty(self::$route)) {
            self::$route = new RouteCollector(new Std, new GroupCountBased);
        }
    }

    public static function parse()
    {
        self::$dispatcher = new FastDispatcher(self::getData());
        $http_method = $_SERVER['REQUEST_METHOD']; //请求类型
        $uri = $_SERVER['REQUEST_URI'];
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos); //获取去除参数的uri
        }
        $uri = rawurldecode($uri);
        $route_info = self::$dispatcher->dispatch($http_method, $uri);
        switch ($route_info[0]) {
            case Dispatcher::NOT_FOUND:
                header('HTTP/1.1 404 Not Found');
                echo "Not Found";
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                header('HTTP/1.1 304 Refuse');
                $allowedMethods = $route_info[1];
                echo "Request method not allow";
                break;
            case Dispatcher::FOUND:
                $handler = $route_info[1];
                $vars = $route_info[2];
                //根据匹配到的路由，解析到相应的控制器
                try {
                    $namespace = isset(self::$namesapce[$uri]) ? self::$namesapce[$uri]: '';
                    CPatcher::patcher($handler, $vars, $namespace);
                } catch (\Exception $e) {
                    echo "Error";
                }
                break;
        }
    }

    public static function get($uri, $handle, $namespace = '')
    {
        self::init();
        if (!empty($namespace)) {
            self::$namesapce[$uri] = $namespace;
        }
        return self::$route->addRoute('GET', $uri, $handle);
    }

    public static function post($uri, $handle, $namespace)
    {
        self::init();
        if (!empty($namespace)) {
            self::$namesapce[$uri] = $namespace;
        }
        return self::$route->addRoute('GET', $uri, $handle);
    }

    public static function group($prefix, Array $route = [])
    {
        self::init();
        self::$route->addGroup($prefix, function (RouteCollector $r) use ($route){
            foreach ($route as $key => $value) {
                $r->addRoute('GET', $key, $value);
            }
        });
    }

    public static function getData()
    {
        self::init();
        return self::$route->getData();
    }

}




