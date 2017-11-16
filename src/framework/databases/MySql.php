<?php
/**
 * MySQL 实现类
 * User: end_wiki
 * Date: 2017/11/16
 * Time: 9:30
 */
namespace src\framework\databases;

class MySql {

    private $databaseInstance = null;               // 数据库实例
    private $fields = null;
    private $where = null;
    private $table = null;
    private $order = null;
    private $group = null;
    private $having = null;
    private $lastSql = null;
    private $limit = null;
    private $prepareValues = [];          // PDO 预处理的字段


    /**
     * MySql constructor.
     * @param \PDO $database \PDO 实例
     */
    public function __construct(\PDO $database){
        $this->databaseInstance = $database;
    }

    /**
     * 指定条件
     * @param array $conditions 指定的条件
     * @return $this
     */
    public function where(array $conditions){
        foreach($conditions as $field => $value){
            // 判断是否指定操作符
            if(is_array($value)){
                $operation = $this->operationConvert($value[0]);
                $value = $value[1];
            }

            $operation = isset($operation) ? (' ' . $operation . ' ') : ' = ';
            $this->where .= ' AND `' . $field . '`' . $operation . '?';
            // 纪录预处理的字段和值的映射
            $this->prepareValues[] =  $value;
        }
        $this->where = substr($this->where,4);
        return $this;
    }

    /**
     * 操作符转换
     * @param String $operation 操作符
     * @return bool|string
     */
    private function operationConvert(String $operation){
        $map = [
            'eq'    =>      '=',
            'neq'   =>      '<>',
            'gt'    =>      '>',
            'egt'   =>      '>=',
            'lt'    =>      '<',
            'elt'   =>      '<=',
            'like'  =>      'like',
            'in'    =>      'in',
        ];
        if(!in_array($operation,array_keys($map))){
            return false;
        }
        return $map[$operation];
    }

    /**
     * 指定表名
     * @param String $name 表名
     * @return $this
     */
    public function table(String $name){
        $this->table = $name;
        return $this;
    }

    /**
     * 指定字段
     * @param array $fields  字段
     * @return $this
     */
    public function field(array $fields){
        $this->fields = '`' . implode('`,`',$fields) . '`';
        return $this;
    }

    public function join(array $join){

    }


    public function group(){

    }

    public function having(){

    }

    public function order(){

    }

    /**
     * 获取纪录
     * @return mixed
     */
    public function fetch(){
        if(is_null($this->table)){
            echo 'Table not is empty!';
            // 抛出异常
        }
        if(is_null($this->fields)){
            $this->fields = '*';
        }
        if(is_null($this->where)){
            $this->where = '1=1';
        }
        if(is_null($this->limit)){
            $this->limit = 1;
        }
        $sql = 'SELECT ' . $this->fields
            . ' FROM ' . $this->table
            . ' WHERE ' . $this->where
            . ' LIMIT ' . $this->limit;
        $this->lastSql = $sql;              // 记录最后一次执行的 SQL
        $statementObject = $this->databaseInstance->prepare($sql);

        $statementObject->execute($this->prepareValues);
        $statementObject->debugDumpParams();
        return $statementObject->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * 指定返回纪录条数
     * @param int $number 纪录条数
     * @return $this
     */
    public function limit(int $number){
        $this->limit = $number;
        return $this;
    }

    /**
     * 获取最后一次执行的 SQL
     * @return string
     */
    public function getLastSql(){
        return $this->lastSql;
    }

    public function insert(){

    }

    public function insertAll(){

    }

    /**
     * 更新记录
     * @param array $data 将要更新的字段和字段值
     * @return bool
     */
    public function update(array $data){
        $values = [];
        $updateFields = '';
        // 拼接更新的字段
        foreach($data as $item => $value){
            $updateFields .= '`' . $item . '` = ? ,';
            $values[] = $value;
        }
        // 去除末尾多余的逗号
        $updateFields = substr($updateFields , 0 , mb_strlen($updateFields) - 1);
        $sql = 'UPDATE ' . $this->table . ' SET ' . $updateFields . ' WHERE ' . $this->where;
        $statementObject = $this->databaseInstance->prepare($sql);
        // 将更新的预处理字段值和 Where 条件中的预处理字段值组合
        $values = array_merge($values,$this->prepareValues);
        $updateResult = $statementObject->execute($values);
        return $updateResult;
    }

    public function sum(){

    }

    public function count(){

    }

    public function delete(){

    }

    public function getField(){

    }
}