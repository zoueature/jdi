<?php
/**
 * Created by PhpStorm.
 * User: eature
 * Date: 18-11-18
 * Time: 上午10:17
 */

namespace Core;


class Model
{
    private $instance;
    private $config = [];

    /** @var string 主键名 */
    protected $primary = 'id';

    /** @var string 表名 */
    protected $table = '';

    /** @var array 可以更新的字段 */
    protected $update = [];

    /** @var string 左后一次操作的sql */
    protected $last_sql = '';

    /** @var string 最后一次查询的条件 */
    private $where = '';

    public function __construct()
    {
        if (!($this->instance instanceof \PDO)) {
            try {
                $this->instance = $this->connect();
            } catch (\Exception $e) {

            }
        }
    }

    protected function connect(Array $option = [])
    {
        if (empty($this->config)) {
            $config = config('db');
            if (empty($config)) {
                throw new JdiException('connect DB fail no config');
            }
            $this->config = $config['master'];
        }
        $config = $this->config['master'];
        switch (strtolower($this->config['type'])) {
            default: //默认是mysql
                $dsn = "mysql:host={$config['host']};dbname={$config['dbname']}";
                $pdo = new \PDO($dsn, $config['user'], $config['pswd'], $option);
        }
        return $pdo;
    }

    /**
     * ------------------------------------------------------
     * where条件
     * -------------------------------------------------------
     */
    public function where($conf)
    {
        if (is_array($conf)) {
            //数组形式的参数
            $where = '';
            foreach ($conf as $column => $value) {
                if (!is_array($value)) {
                    $where .= "`$column` = $value, ";
                    continue;
                }
                foreach ($value as $operation => $item) {
                    $where .= "`$column` $operation '$item', ";
                }
            }
            $where = rtrim($where, ',');
        } else if (is_string($conf)) {
            $where = $conf;
        } else {
            $param_type = gettype($conf);
            throw new JdiException('where function params expect array or string, '.$param_type.'given');
        }
        $this->where = $where;
        return $this;
    }

    public function find()
    {
        $rows = $this->select();
        if (empty($rows)) {
            return [];
        }
        return $rows[1];
    }

    public function execSql()
    {

    }

    public function select()
    {
        $select_sql = "SELECT ";
    }

    public function insert(Array $insert_data)
    {
        $insert_sql = 'INSERT INTO '.$this->table;
        $column = '';
        foreach ($insert_data as $column => $value) {
            $column .= "`$column`, ";
            $value .= "'$value', ";
        }
        $column = rtrim($column, ',');
        $value = rtrim($value, ',');
        $insert_sql .= "($column) VALUES ($value)";
        $this->last_sql = $insert_sql;
    }

    public function update(Array $update_data)
    {

    }
    /**
     * ------------------------------------------------------
     *  根据主键获取对应的行数据
     * -------------------------------------------------------
     */
    public function get($primary_value)
    {
        $this->instance->where([$this->primary => $primary_value])->find();
    }

}







