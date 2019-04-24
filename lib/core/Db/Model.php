<?php
/*
 | ------------------------------
 | User: Zoueature
 | Date: 2019/4/24
 | Time: 9:40
 | ------------------------------
 */

namespace Core\Db;


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
        $sqlLogSwitch = $logSwitch['sql'] ?: true;
        $this->logSwitch = $sqlLogSwitch;
        if (empty($table)) {
            $table = get_class();
        }
        $this->table = $table;
    }

    protected function init(array $config)
    {
        $configuration = make(Configuration::class);
        $conn = DriverManager::getConnection($config, $configuration);
        $this->conn = $conn;
    }

    public function __call($name, $arguments)
    {
        if (in_array($name, $this->builderFunc)) {
            if (empty($this->builder)) {
                $this->builder = $this->conn->createQueryBuilder();
            }
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
        $stm = $this->builder->select('*')
            ->from($this->table)
            ->where($this->primary.' = ?')
            ->setParameter(0, $value);
        $result = $stm->fetchAll();
        return $result;
    }
}