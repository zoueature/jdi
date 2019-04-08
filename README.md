# jdi
just do it, a simple framework by myself

1. 安装依赖 ```composer install```
2. 编写相关路由， `/path/to/jdi/route/api.php`
3. 控制器位于 `/path/to/jdi/app/Controller`, 所有的控制器继承自`Core\Controller`（可选）
4. 数据库操作位于`/path/to/jdi/app/Model`, 所有的模型必须继承自`Core\Model`
5. 所有的log均打在`/path/to/jdi/logs`下
