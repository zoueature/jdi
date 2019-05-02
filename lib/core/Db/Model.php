<?php
/*
 | ------------------------------
 | User: Zoueature
 | Date: 2019/4/24
 | Time: 9:40
 | ------------------------------
 */

namespace Core\Db;


use Core\Common\Logger;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Driver\PDOStatement;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Query\QueryBuilder;

class Model
{
    protected $config;
    protected $conn;
    protected $logSwitch;
    protected $primary = 'id';
    protected $table;
    protected $builder;
    protected $prefix;
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
        'execute',
    ];

    public function __construct(string $table = '', string $prefix = '', string $db = 'master')
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
        if (empty($prefix)) {
            $prefix = $dbConfig['prefix'];
        }
        $this->prefix = $prefix;
        if (empty($this->table)) {
            $this->table = $table;
        }
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
            if (!empty($this->queryResult) && $this->queryResult instanceof QueryBuilder) {
                $res = call_user_func_array([$this->queryResult, $name], $arguments);
            } else {
                $this->builder = $this->conn->createQueryBuilder();
                $builder = $this->builder;
                $res = call_user_func_array([$builder, $name], $arguments);
            }
            $this->queryResult = $res;
            if (in_array($name, ['execute'])) {
                $this->queryResult = null;
                if ($res instanceof PDOStatement) {
                    return $res->fetchAll();
                }
                return $res;
            }
        }
        return $this;
    }


    public function getByPrimary($value)
    {
        $stm = $this->conn
            ->createQueryBuilder()
            ->select('*')
            ->from($this->prefix.$this->table)
            ->where($this->primary.' = :primary')
            ->setParameter(':primary', $value)
            ->setMaxResults(1)
            ->execute();
        $result = $stm->fetchAll();
        return $result[0];
    }
}