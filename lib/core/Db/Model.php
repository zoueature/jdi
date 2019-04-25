<?php
/*
 | ------------------------------
 | User: Zoueature
 | Date: 2019/4/24
 | Time: 9:40
 | ------------------------------
 */

namespace Core\Db;


use Core\Logger;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;

class Model
{
    protected $config;
    protected $conn;
    protected $logSwitch;
    protected $primary = 'id';
    protected $table;
    protected $builder;
    protected $builderFunc = [
        'select',
        'from',
        'where',
        'setParameter',
        'insert',
        'update',
        'delete',
        'groupBy',
        'having',
        'orWhere',
        'andHaving',
        'orHaving',
        'addGroupBy',
        'join',
        'innerJoin',
        'leftJoin',
        'rightJoin',
        'orderBy',
        'setFirstResult',
        'setMaxResults',
        'values',
        'setValue',
        'set',
        'having',
        'having',
        'having',
    ];

    public function __construct(string $table = '', string $db = 'master')
    {
        $config = config('db');
        $dbConfig = $config[$db];
        if (empty($dbConfig)) {
            throw new JdiException('Init database error, No config', JdiException::ERROR_EMPTY);
        }
        $this->init($dbConfig);
        $logSwitch = config('log');
        $sqlLogSwitch = $logSwitch['sql'] ?? true;
        $this->logSwitch = $sqlLogSwitch;
        if (empty($table)) {
            $table = get_class();
        }
        $this->table = $table;
    }

    protected function init(array $config)
    {
        $configuration = make(Configuration::class);
        $connectionParams = array(
            'dbname' => $config['name'],
            'user' => $config['user'],
            'password' => $config['pswd'],
            'host' => $config['host'],
            'driver' => $config['driver'] ?? 'pdo_mysql',
        );
        $conn = DriverManager::getConnection($connectionParams, $configuration);
        $this->conn = $conn;
        $this->builder = $this->conn->createQueryBuilder();
    }

    public function __call($name, $arguments)
    {
        if (in_array($name, $this->builderFunc)) {
            $this->builder = $this->conn->createQueryBuilder();
            $builder = $this->builder;
            $microtime = microtime(true);
            call_user_func_array([$builder, $name], $arguments);
            $microtimeEnd = microtime(true);
            $costTime = $microtimeEnd - $microtime;
            Logger::sql('Cost: '.$costTime.' '.$builder->getSQL());
        }
        call_user_func_array([$this, $name], $arguments);
    }


    public function getByPrimary($value)
    {
        $stm = $this->conn
            ->createQueryBuilder()
            ->select('*')
            ->from($this->table)
            ->where($this->primary.' = :primary')
            ->setParameter(':primary', $value)
            ->setMaxResults(1)
            ->execute();
        $result = $stm->fetchAll();
        return $result[0];
    }
}