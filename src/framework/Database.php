<?php
/**
 * 数据库类
 * User: end_wiki
 * Date: 2017/10/22
 * Time: 19:09
 */
namespace src\framework;

use app\common\exceptions\CreateDatabaseInstanceFailedException;

class Database {

    private static $instance = [];

    /**
     * 获取数据库实例
     * @param string $host 数据库 URL
     * @param string $dbName 数据库名
     * @param null $userName 数据库用户名
     * @param null $password 数据库密码
     * @param int $port default 3306
     * @param string $charset default UTF8
     * @return object
     * @throws CreateDatabaseInstanceFailedException [300001]创建数据库实例失败
     */
    public static function getInstance($host,$dbName,$userName = null,$password = null,$port = 3306,$charset = 'UTF8'){
        // 创建实例唯一标识
        $id = serialize($host . $dbName . $port);
        $instances = self::$instance;
        if(!isset($instances[$id])){
            if(is_null($userName) || is_null($password)){
                throw new CreateDatabaseInstanceFailedException();
            }
            // 创建实例
            $dsn = 'mysql:dbname=' . $dbName . ';host=' . $host . ';port=' . $port . ';charset=' . $charset;
            try{
                $instances[$id] = new \PDO($dsn,$userName,$password);
            } catch(\PDOException $e){
                throw new CreateDatabaseInstanceFailedException();
            }
        }
        return $instances[$id];
    }
}