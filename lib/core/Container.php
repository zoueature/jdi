<?php
/**
 * Created by PhpStorm.
 * User: eature
 * Date: 18-12-22
 * Time: 上午9:46
 * 服务容器
 */

namespace Core;


class Container
{
    /** @var array 实例生成的方式 */
    private static $bind = [];

    private $single = [];

    private $instance = [];

    /**
     * -------------------------------------------------------
     *  绑定类实例的生成方法
     * -------------------------------------------------------
     */
    public function bind($class_name, $instance_method, $single = true)
    {
        if (isset(self::$bind[$class_name])) {
            return true;
        }
        self::$bind[$class_name] = $instance_method;
        $this->single[$class_name] = $single;
        return true;
    }

    /**
     * -------------------------------------------------------
     *  数组批量绑定
     * -------------------------------------------------------
     */
    public function bindWithArray(array $binds, array $singles = [])
    {
        self::$bind = array_merge(self::$bind, $binds);
        if (!empty($singles)) {
            $this->single = array_merge($this->single, $singles);
        }
    }

    /**
     * -------------------------------------------------------
     * 获取指定类的实例化对象
     * -------------------------------------------------------
     */
    public function make($class)
    {
        $instance = $this->instance($class);
        return $instance;
    }

    /**
     * -------------------------------------------------------
     *  判断该类是否可以实例化
     * -------------------------------------------------------
     */
    private function isBuildable($class)
    {
        //TODO 可实例化，则构造函数没有参数
        return true;
    }

    private function getDependence(\ReflectionClass $reflection_class)
    {
        $construct = $reflection_class->getConstructor();
        if (empty($construct)) {
            //没有构造函数, 返回空, 即不依赖于其他类
            return [];
        }
        //获取构造函数的参数名，即其依赖
        $params = $construct->getParameters();
        if (empty($params)) {
            return [];
        }
        $data = [];
        foreach ($params as $param) {
            $param_class = $param->getClass();
            if (!empty($param_class)) {
                $data[] = $param->getClass()->getName();
            } else {
                throw new JdiException('can not instance with standard variable');
            }
        }
        return $data;
    }

	private function solveDependence($dependence)
	{
	    $instances = [];
	    foreach ($dependence as $item) {
	        $instances[] = $this->make($item);
        }
	    return $instances;
	}

    /**
     * -------------------------------------------------------
     *  解决依赖并实例化对象
     * -------------------------------------------------------
     */
	private function instance($class)
	{
		$method = isset(self::$bind[$class]) ? self::$bind[$class] : $class; //实例化对象的方法
		$single = isset($this->single[$class]) ? $this->single[$class] : true; //是否单实例
        //单实例则返回已经实例化的对象
		if ($single &&
			isset($this->instance[$class]) &&
			$this->instance[$class] instanceof $class) {
			return $this->instance[$class];
		}
		if (empty($method)) {
			return null;
		}
		//闭包实现则直接执行闭包
		if ($method instanceof \Closure) {
			$instance = $method();
			return $instance;
		}
		if (!is_string($method)) {
		    return null;
        }
		try {
            $reflection_class = new \ReflectionClass($method);
        } catch (\Exception $e) {
		    return null;
        }
		$dependence = $this->getDependence($reflection_class);
		//没有依赖则直接实例化
		if (empty($dependence)) {
		    $instance = new $method;
		    return $instance;
        }
		$params_instances = $this->solveDependence($dependence);
		try {
            $instance = $reflection_class->newInstanceArgs($params_instances);
        } catch (\Exception $e) {
		    return null;
        }
		return $instance;
	}
}




