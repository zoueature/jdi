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
    protected $table;

    /** @var array 可以更新的字段 */
    protected $update;

    /** @var string 最后一次操作的sql */
    protected $last_sql;

    /** @var string 最后一次查询的条件 */
    private $where;

    private $query_fileds = '*';

    private $value_map;

    private $fetch_type = \PDO::FETCH_COLUMN;

    public function __construct(string $table = '')
    {
        if (empty($table)) {
            $this->table = ''; //类名
        } else {
            $this->table = $table;
        }
        if (!($this->instance instanceof \PDO)) {
            try {
                $this->instance = $this->connect();
            } catch (\Exception $e) {
                var_dump($e->getMessage());
                Logger::error($e->getMessage());
            }
        }
    }

    public function setFetchType(int $type) :void
    {
        $this->fetch_type = $type;
    }

    /**
     * -------------------------------------------------------
     *  链接数据库
     * -------------------------------------------------------
     */
    protected function connect(array $option = []) :\PDO
    {
        if (empty($this->config)) {
            $config = config('db');
            $this->config = $config;
        }
        $config = $this->config['master'];
        switch (strtolower($this->config['type'])) {
            default: //默认是mysql
                $dsn = "mysql:host={$config['host']};dbname={$config['name']}";
                $pdo = new \PDO($dsn, $config['user'], $config['pswd'], $option);
        }
        return $pdo;
    }

    /**
     * -------------------------------------------------------
     *  执行一条查询语句
     * -------------------------------------------------------
     */
    public function query($sql) :array
    {
        $pdo_statement = $this->instance->query($sql);
        if (empty($pdo_statement)) {
            return [];
        }
        $all_result = $pdo_statement->fetchAll();
        return $all_result;
    }

    public function field($fields) :Model
    {

    }
    /**
     * ------------------------------------------------------
     * 添加where条件
     * -------------------------------------------------------
     */
    public function where($condition) :Model
    {
        if (is_array($condition)) {
            //数组形式的参数
            $where = '';
            foreach ($condition as $column => $value) {
                if (!is_array($value)) {
                    $where .= "`$column` = $value, ";
                    continue;
                }
                foreach ($value as $operation => $item) {
                    $where .= "`$column` $operation '$item', ";
                }
            }
            $where = rtrim($where, ', ');
        } else if (is_string($condition)) {
            $where = $condition;
        } else {
            return $this;
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
        $sql = 'SELECT '
            .$this->query_fileds
            .' from '
            .$this->table;
        if (!empty($this->where)) {
            $sql .= ' ' .$this->where;
        }
        $this->last_sql = $sql;
        return $this->query($this->last_sql);
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







