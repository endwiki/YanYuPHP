<?php
/**
 * 用户模型类
 * User: end_wiki
 * Date: 2017/10/22
 * Time: 21:14
 */
namespace app\api\model;


use src\framework\Config;
use src\framework\Database;

class User {

    /**
     * 根据用户名检查用户是否存在
     * @param string $username 用户名
     * @return bool
     */
    public static function hasExistByUsername($username){
        $dbConfig = Config::get('database');
        $dbInstance = Database::getInstance($dbConfig['host'],$dbConfig['db'],$dbConfig['user'],$dbConfig['password']);
        // 查询该用户是否存在
        $queryUserInfoSql = 'SELECT user_id,username,password FROM user WHERE username=:username AND status=1';
        $statementObject = $dbInstance->prepare($queryUserInfoSql);
        $statementObject->execute(['username'=>$username]);
        $userInfo = $statementObject->fetch(\PDO::FETCH_ASSOC);
        if($userInfo){
            return $userInfo;
        }
        return false;
    }
}