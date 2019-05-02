<?php
/**
 * Created by PhpStorm.
 * User: Zou
 * Date: 2019/1/15
 * Time: 9:35
 *
 * 注册类，提供相关服务的注册方法
 */

namespace Core\Boot;


use Core\Container;
use Core\Db\Model;
use App\Service\ServiceRegister as UserServiceRegister;

class ServiceRegister
{
    private $container = null;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /* -----------------------------------------
     * 绑定框架核心类到容器中
     * -----------------------------------------
     */
    public function registerCoreService()
    {
        $this->container->bindWithArray([
            'Utils\\IdGenerateModel' => function() {
                return new Model('id_generate');
            }
        ]);
    }

    /* --------------------------------------
     * 绑定用户服务
     * --------------------------------------
     */
    public function registerUserService()
    {
        $userService = UserServiceRegister::register();
        $userSingle = UserServiceRegister::single();
        $this->container->bindWithArray($userService, $userSingle);
    }

}