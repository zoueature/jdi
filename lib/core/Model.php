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
    protected $instance;
    protected $config = [];

    /** @var string 主键名 */
    protected $primary = 'id';

    /** @var string 表名 */
    protected $table;

    /** @var array 可以更新的字段 */
    protected $update;

    /** @var string 最后一次操作的sql */
    protected $last_sql;

    /** @var string 最后一次查询的条件 */
    protected $where;

    protected $query_fields = '*';

    protected $value_map;

    protected $table_prefix = 't_';

    protected $fetch_type = \PDO::FETCH_COLUMN;

    protected $offset;

    protected $limit;

    protected $offset;

    protected $limit;

    public function __construct($table = '', $prefix = '')
    {
        if (empty($table)) {
            $this->table = ''; //类名
        } else {
            $this->table = $table;
        }
        if (!empty($prefix)) {
            $this->table_prefix = $prefix;
        }
        $this->table = $this->table_prefix.$this->table;

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
        switch (strtolower($config['type'])) {
            default: //默认是mysql
                $dsn = "mysql:host={$config['host']};dbname={$config['name']}";
                $pdo = new \PDO($dsn, $config['user'], $config['pswd'], $option);
        }
        $pdo->exec('set names '.$config['charset']);
        return $pdo;
    }

    /**
     * -------------------------------------------------------
     *  清除单次查询的条件等相关数据
     * -------------------------------------------------------
     */
    private function unsetCondition()
    {
        $this->where = null;
        $this->query_fields = null;
    }
    /**
     * -------------------------------------------------------
     *  执行一条查询语句
     * -------------------------------------------------------
     */
    public function query($sql) :array
    {
        $pdo_statement = $this->instance->query($sql);
        if ($pdo_statement !== false) {
            Logger::sql($sql);
        } else {
            Logger::sqlError($sql);
        }
        if (empty($pdo_statement)) {
            return [];
        }
        $all_result = $pdo_statement->fetchAll();
        $this->unsetCondition();
        return $all_result;
    }

    /**
     * -------------------------------------------------------
     *  设置需要查询的属性
     * -------------------------------------------------------
     */
    public function field($fields) :Model
    {
        $str = '';
        if (is_array($fields)) {
            foreach ($fields as $field) {
                $str .= "`$field`, ";
            }
            $str = rtrim($str, ', ');
        } else if (is_string($fields)){
            $str = $fields;
        } else {
            return $this;
        }
        $this->query_fields = $str;
        return $this;
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
                    $where .= "`$column` = '$value' AND ";
                    continue;
                }
                foreach ($value as $operation => $item) {
                    $where .= "`$column` $operation '$item'AND ";
                }
            }
            $where = rtrim($where, 'AND ');
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
        $this->limit(1);
        $rows = $this->select();
        if (empty($rows)) {
            return [];
        }
        return $rows[0];
    }

    /**
     * -------------------------------------------------------
     *  执行一条操作语句,返回受影响的函数
     * -------------------------------------------------------
     */
    public function execSql($sql)
    {
        $effect_row = $this->instance->exec($sql);
        return $effect_row;
    }

    public function select()
    {
        $sql = 'SELECT '
            .$this->query_fields
            .' from '
            .$this->table;
        if (!empty($this->where)) {
            $sql .= ' WHERE ' .$this->where;
        }
        if ($this->offset !== null) {
            $sql .= ' OFFSET '.$this->offset;
        }
        if ($this->limit !== null) {
            $sql .= ' LIMIT '.$this->limit;
        }
        $this->last_sql = $sql;
        return $this->query($this->last_sql);
    }

    public function insert(array $insert_data)
    {
        $insert_sql = 'INSERT INTO '.$this->table;
        $column_str = '';
        $value_str = '';
        foreach ($insert_data as $column => $value) {
            $column_str .= "`$column`, ";
            $value_str .= "'$value', ";
        }
        $column = rtrim($column_str, ', ');
        $value = rtrim($value_str, ', ');
        $insert_sql .= "($column) VALUES ($value)";
        $this->last_sql = $insert_sql;
        return $this->execSql($this->last_sql);
    }

    public function update(array $update_data)
    {

    }

    /* ------------------------------------------------------
     *  根据主键获取对应的行数据
     * -------------------------------------------------------
     */
    public function get($primary_value)
    {
        $this->instance->where([$this->primary => $primary_value])->find();
    }

    /* -----------------------------------------
     * 设置limit属性
     * -----------------------------------------
     */
    public function limit($offset, $limit = false)
    {
        if ($limit === false) {
            $this->limit = $offset;
            return $this;
        }
        $this->offset = $offset;
        $this->limit = $limit;
        return $this;
    }
}







