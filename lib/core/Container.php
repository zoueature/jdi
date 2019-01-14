<?php
/**
 * Created by PhpStorm.
 * User: eature
 * Date: 18-12-22
 * Time: 上午9:46
 */

namespace Core;


class Container
{
    /** @var array 实例生成的方式 */
    private $bind = [];

    private $instance = [];

    /**
     * -------------------------------------------------------
     *  绑定类实例的生成方法
     * -------------------------------------------------------
     */
    public function bind($class_name, $instance_method, $single = false)
    {
        if (isset($this->bind[$class_name])) {
            return true;
        }
        $this->bind[$class_name]['method'] = $instance_method;
        $this->bind[$class_name]['single'] = $single;
    }

    /**
     * -------------------------------------------------------
     *  判断该类是否可以实例化
     * -------------------------------------------------------
     */
    private function isBuildable($class)
    {

    }

    private function getDependence($class)
    {
        try {
            $reflection = new \ReflectionClass($class);
        } catch (\Exception $e) {
            Logger::error('get Dependence error');
            return false;
        }
        $contruct = $reflection->getConstructor();
        if (empty($contruct)) {
            //没有构造函数, 返回空, 即不依赖于其他类
            return [];
        }
        //获取构造函数的参数名，即其依赖
        $params = $contruct->getParameters();
        return $params;
    }

    private function buildInstance($class)
    {
        if (isset($this->instance[$class])) {
			//单实例，直接返回实例对象
			return $this->instance[$class];
		}
		$dependences = $this->getDependence($class);
		if (empty($denpences)) {
			$instance = $this->instance($class);
		} else {
		}
    }

	private function solveDependence($dependences)
	{
	
	}

	private function instance($class)
	{
		$method = $this->bind[$class]['method'];
		$single = $this->bind[$class]['single'];
		if ($single &&
			isset($this->instance[$class]) &&
			($this->instance[$class] instanceof $class)) {
			return $this->instance[$class];
			}
		if (empty($method)) {
			return false;
		}
		if ($method instanceof Closure) {
			//闭包函数
		}
		$instance = new $method;
		if ($single) {
			$this->instance[$class] = $instance;
		}
		return $instance;
	}
}




