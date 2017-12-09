<?php
/**
 * MySQL 实现类
 * User: end_wiki
 * Date: 2017/11/16
 * Time: 9:30
 */
namespace src\framework\databases;

use src\framework\Cache;
use src\framework\exceptions\CreateMySQLInstanceFailedException;
use src\framework\exceptions\DatabaseExecuteFailedException;
use src\framework\exceptions\DatabaseInsertDataHasEmptyException;
use src\framework\exceptions\DatabaseJoinTypeNotMissException;
use src\framework\exceptions\DatabaseTableNotMissException;
use src\framework\Logger;


class MySQL implements DatabaseInterface {

    private $fields = null;
    private $where = null;
    private $table = null;
    private $join = null;
    private $order = null;
    private $group = null;
    private $having = null;
    private $lastSql = null;
    private $limit = null;
    private $prepareValues = [];          // PDO 预处理的字段
    protected $errorInfo = [];
    protected $databaseInstance;

    /**
     * 获取数据库实例
     * @param array $config 数据库配置
     * @return mixed
     * @throws CreateMySQLInstanceFailedException [100023]创建MySQL数据库实例失败
     */
    public function __construct(array $config){
        $config['PORT'] = $config['PORT'] ?? 3306;      // 端口默认值
        // 创建实例
        $dsn = 'mysql:dbname=' . $config['NAME'] . ';host='
            . $config['HOST'] . ';port=' . $config['PORT']
            . ';charset=' . $config['CHARSET'];
        try{
            $instance = new \PDO($dsn,$config['USER'],$config['PASSWORD']);
        } catch(\PDOException $e){
            throw new CreateMySQLInstanceFailedException();
        }
        $this->databaseInstance = $instance;
        return $this;
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

    /**
     * 指定 JOIN 子句
     * @param String $table 关联表名
     * @param String $condition 关联条件
     * @param String $type 关联类型 default 'INNER' option [INNER|LEFT|RIGHT]
     * @return $this
     * @throws DatabaseJoinTypeNotMissException [100008]数据库关联语句类型没有找到异常
     */
    public function join(String $table,String $condition,String $type = 'INNER'){
        $type = strtoupper($type);      // 转成大写
        $typeList = ['INNER','LEFT','RIGHT'];
        if(!in_array($type,$typeList)){
            throw new DatabaseJoinTypeNotMissException();
        }
        $this->join .= ' ' . $type . ' JOIN `' . $table . '` ON ' . $condition ;
        return $this;
    }

    /**
     * 指定 GROUP BY 字句
     * @param String $group GROUP 字句
     * @return $this
     */
    public function group(String $group){
        $this->group = ' GROUP BY ' . $group;
        return $this;
    }

    /**
     * 指定 HAVING 字句
     * @param String $having HAVING 字句
     * @return $this
     */
    public function having(String $having){
        $this->group = $this->group . ' HAVING ' . $having;
        return $this;
    }

    /**
     * 设置排序字句
     * @param String $order 排序字符串
     * @return $this
     */
    public function order(String $order){
        $this->order = $order;
        return $this;
    }

    /**
     * 查询记录
     * @param bool $cache 是否缓存 default false
     * @return array|mixed
     * @throws DatabaseTableNotMissException [100007]数据库表没有找到异常
     */
    public function fetch(bool $cache = false){
        if(is_null($this->table)){
            throw new DatabaseTableNotMissException();
        }
        // 赋予初值
        $this->fields = $this->fields ?? '*';
        $this->where = $this->where ?? '1=1';
        $this->order = $this->order ?? '1=1';
        $this->group = $this->group ?? '';
        $this->join = $this->join ?? '';
        if($this->where == '1=1' && is_null($this->limit)){
            $this->limit = ' LIMIT 1 ';
        }
        // 拼接 SQL
        $sql = 'SELECT ' . $this->fields
            . ' FROM ' . $this->table
            . $this->join
            . ' WHERE ' . $this->where
            . $this->group
            . ' ORDER BY ' . $this->order
            . $this->limit;
        $this->setLastSql($sql);            // 设置上一次执行的SQL
        // 如果存在缓存则读取缓存，否则查询
        $cacheData = Cache::get(md5($sql));
        if(Cache::get(md5($sql))){
            return unserialize($cacheData);
        }else{
            // 查询数据
            $statementObject = $this->databaseInstance->prepare($sql);
            $queryResult = $statementObject->execute($this->prepareValues);
            if(!$queryResult){
                $this->errorInfo = $statementObject->errorInfo();
            }
            if(trim($this->limit) == 'LIMIT 1'){
                $result = $statementObject->fetch(\PDO::FETCH_ASSOC);
            }else{
                $result = $statementObject->fetchAll(\PDO::FETCH_ASSOC);
            }
            // 缓存
            if($cache){
                Cache::set(md5($sql),serialize($result));
            }
        }

        $this->clear();         // 清空成员参数，防止影响下一次查询
        return $result;
    }

    /**
     * 每次执行完之后清理数据
     * @return void
     */
    public function clear(){
        $this->fields = null;
        $this->where = null;
        $this->table = null;
        $this->join = null;
        $this->order = null;
        $this->group = null;
        $this->having = null;
        $this->limit = null;
        $this->prepareValues = [];
    }
    /**
     * 指定返回纪录条数
     * @param int $number 纪录条数
     * @return $this
     */
    public function limit(int $number){
        $this->limit = ' LIMIT ' . $number;
        return $this;
    }
    /**
     * 获取最后一次执行的 SQL
     * @return string
     */
    public function getLastSql(){
        return $this->lastSql;
    }
    /**
     * 新增数据
     * @param array $data 将要新增的字段和字段值
     * @return bool
     */
    public function add(array $data){
        $fields = [];
        $values = [];
        // 遍历插入的字段和值
        foreach($data as $item => $value){
            $fields[] = $item;
            $values[] = $value;
        }
        $fieldCount = count($fields);
        // 填充符合字段个数的占位符,拼接 SQL
        $placeholder = array_fill(0,$fieldCount,'?');
        $fields = '`' . implode('`,`',$fields) . '`';
        $sql = 'INSERT INTO ' . $this->table
            . ' (' . $fields
            . ') VALUE ('
            . implode(',',$placeholder) . ')';
        $this->setLastSql($sql);
        // 预处理并执行 SQL
        $statementObject = $this->databaseInstance->prepare($sql);
        $insertResult = $statementObject->execute($values);
        if(!$insertResult){
            $this->errorInfo = $statementObject->errorInfo();
        }
        return $insertResult;
    }

    /**
     * 批量插入数据
     * @param array $dataList 将要插入的行数据
     * @return bool
     * @throws DatabaseInsertDataHasEmptyException [100009]插入数据库的数据为空异常
     */
    public function addAll(array $dataList){
        // 检查数据是否为空
        if(count($dataList) == 0){
            throw new DatabaseInsertDataHasEmptyException();
        }
        $insertValue = '';          // 存储插入语句的 VALUES 部分
        // 遍历数据
        foreach($dataList as $dataIndex => $data){
            $fields = [];      // 存储字段
            foreach($data as $field => $value){
                $fields[$field] = $field;           // 存储字段
                $this->prepareValues[] = $value;    // 存储值
            }
            $insertValue .= ',(' . implode(','
                    ,array_fill(0,count($fields),'?')
                ) . ')';
        }
        // 拼接 SQL 并执行
        $sql = 'INSERT INTO `' . $this->table
            . '` (' . implode(',',$fields) . ') VALUES '
            . substr($insertValue,1,strlen($insertValue)) . ';';
        $this->setLastSql($sql);
        $statementObject = $this->databaseInstance->prepare($sql);
        $result = $statementObject->execute($this->prepareValues);
        if(!$result){
            $this->errorInfo = $statementObject->errorInfo();
        }
        return $result;
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
        $this->setLastSql($sql);
        $statementObject = $this->databaseInstance->prepare($sql);
        // 将更新的预处理字段值和 Where 条件中的预处理字段值组合
        $values = array_merge($values,$this->prepareValues);
        $updateResult = $statementObject->execute($values);
        if(!$updateResult){
            $this->errorInfo = $statementObject->errorInfo();
        }
        $this->clear();         // 清除数据，以免影响其他操作
        return $updateResult;
    }

    /**
     * 设置最后执行的 SQL
     * @param String $sql
     */
    protected function setLastSql(String $sql){
        $this->lastSql = $sql;
        // 在 DEBUG 模式下记录日志
        if(DEBUG){
            Logger::getInstance()->add($sql,'SQL');
        }
    }

    /**
     * 获取最后插入的ID
     * @return int
     */
    public function getLastInsertId(){
        return $this->databaseInstance->lastInsertId();
    }

    /**
     * 对执行过程中的错误抛出异常
     * @throws DatabaseExecuteFailedException [100012]MySQL 执行失败异常
     */
    protected function error(){
        throw new DatabaseExecuteFailedException($this->errorInfo[1],$this->errorInfo[2]);
    }

}
