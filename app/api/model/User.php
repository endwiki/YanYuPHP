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
        $databaseInstance = Database::getInstance();
        // 查询该用户是否存在
        $userInfo = $databaseInstance->table('user')
            ->where([
                'username'  =>  $username,
            ])->fetch();
        if($userInfo){
            return $userInfo;
        }
        return false;
    }
}