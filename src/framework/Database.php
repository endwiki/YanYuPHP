<?php
/**
 * 数据库类
 * User: end_wiki
 * Date: 2017/10/22
 * Time: 19:09
 */
namespace src\framework;
use app\common\exceptions\CreateDatabaseInstanceFailedException;
use src\framework\databases\MySql;
class Database {
    private static $instance = [];
    private static $mysql = null;
    /**
     * 获取数据库实例
     * @return MySql
     * @throws CreateDatabaseInstanceFailedException [300001]创建数据库实例失败
     */
    public static function getInstance(){
        $dbConfig = self::getDefaultConfig();
        // 创建实例唯一标识
        $id = serialize($dbConfig['host'] . $dbConfig['db'] . $dbConfig['port']);
        $instances = self::$instance;
        if(!isset($instances[$id])){
            if(is_null($dbConfig['user']) || is_null($dbConfig['password'])){
                throw new CreateDatabaseInstanceFailedException();
            }
            // 创建实例
            $dsn = 'mysql:dbname=' . $dbConfig['db'] . ';host=' . $dbConfig['host'] . ';port=' . $dbConfig['port']. ';charset=' . $dbConfig['charset'];
            try{
                $instances[$id] = new \PDO($dsn,$dbConfig['user'],$dbConfig['password']);
            } catch(\PDOException $e){
                throw new CreateDatabaseInstanceFailedException();
            }
        }
        // 避免重复实例化 MySQL 类
        $mysqlInstance = self::$mysql;
        if(is_null($mysqlInstance)){
            self::$mysql = self::$mysql = new MySql($instances[$id]);
        }
        return self::$mysql;
    }
    /**
     * 获取数据库默认配置
     * @return mixed
     */
    private static function getDefaultConfig(){
        $dbConfig = Config::get('database');
        return $dbConfig;
    }
}