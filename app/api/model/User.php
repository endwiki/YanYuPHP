<?php
/**
 * 用户模型类
 * User: end_wiki
 * Date: 2017/10/22
 * Time: 21:14
 */
namespace app\api\model;


use app\api\org\Token;
use app\common\exceptions\RegisteredUserAlreadyExistsException;
use app\common\exceptions\UsernameOrPasswordWrongException;
use app\common\exceptions\UserNotExistException;
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
        if(!$userInfo){
            return false;
        }
        return true;
    }

    /**
     * 用户登陆
     * @param String $username 用户名
     * @param String $password 用户密码
     * @return mixed
     * @throws UserNotExistException [200006]用户不存在异常
     * @throws UsernameOrPasswordWrongException [200005]用户名密码错误异常
     */
    public static function login(String $username,String $password){
        // 验证用户是否存在
        $userInfo = self::getUserInfo($username);
        if(!$userInfo){
            throw new UserNotExistException();
        }

        // 验证用户密码是否正确
        if(!password_verify($password,$userInfo['password'])){
            throw new UsernameOrPasswordWrongException();
        }
        // 获取 Token
        $token = Token::createToken($userInfo['user_id']);
        return $token;
    }

    /**
     * 根据用户名获取用户信息
     * @param String $username 用户名
     * @return mixed
     */
    public static function getUserInfo(String $username){
        $databaseInstance = Database::getInstance();
        $userInfo = $databaseInstance->table('user')
            ->where([
                'username'  =>  $username,
            ])->fetch();

        return $userInfo;
    }

    /**
     * 添加用户
     * @param String $username 用户名
     * @param String $password 密码
     * @return bool
     * @throws RegisteredUserAlreadyExistsException [200003]用户名已经注册异常
     */
    public static function addUser(String $username,String $password){
        $databaseInstance = Database::getInstance();
        $passwordHash = password_hash($password,PASSWORD_DEFAULT,['cost'=>12]);
        $result = $databaseInstance->table('user')
            ->add([
                'username'  =>  $username,
                'password'  =>  $passwordHash,
                'register_time' =>  time()
            ]);
        return $result;
    }
}