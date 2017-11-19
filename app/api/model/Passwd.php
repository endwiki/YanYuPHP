<?php
/**
 * 密码模型类
 * User: end_wiki
 * Date: 2017/11/19
 * Time: 20:07
 */
namespace app\api\model;

use app\common\exceptions\PasswordNotMissException;
use src\framework\Config;
use src\framework\Database;

class Passwd {

    /**
     * 新增密码
     * @param String $title 密码标题
     * @param String $description 密码描述
     * @param String $password 密码明文
     * @param int $userId 用户ID
     * @return bool
     */
    public static function addPasswd(String $title,String $description,String $password,int $userId){
        $databaseInstance = Database::getInstance();
        $iv = substr(hash('sha256',mt_rand(10000000,99999999)),0,16);
        $password = self::encrypt($password,$iv);

        $result = $databaseInstance->table('passwd')
            ->add([
                'title' =>  $title,
                'description'   =>  $description,
                'user_id'   =>  $userId,
                'is_delete' =>  1,
                'create_time'   =>  time(),
                'passwd'    =>   $password,
                'iv'    =>  $iv
            ]);
        return $result;
    }

    /**
     * 获取密码明文
     * @param int $passwordId 密码ID
     * @return string
     * @throws PasswordNotMissException [700002]密码不存在异常
     */
    public static function getPasswd(int $passwordId){
        $databaseInstance = Database::getInstance();
        $passwordInfo = $databaseInstance->table('passwd')
            ->field(['passwd','iv'])
            ->where([
                'passwd_id' =>  $passwordId,
                'is_delete' =>  1
            ])->fetch();
        if(!$passwordInfo){
            throw new PasswordNotMissException();
        }
        $password = self::decrypt($passwordInfo['passwd'],$passwordInfo['iv']);
        return $password;
    }

    /**
     * 根据密码标题判断密码是否已经存在
     * @param String $title 密码标题
     * @param int $userId 用户ID
     * @return bool
     */
    public static function hasExistByTitle(String $title,int $userId){
        $databaseInstance = Database::getInstance();
        $passwordInfo = $databaseInstance->table('passwd')
            ->where([
                'title' =>  $title,
                'user_id' => $userId
            ])->fetch();
        if(!$passwordInfo){
            return false;
        }
        return true;
    }

    /**
     * 加密
     * @param String $password 明文
     * @param String $iv 初始化向量
     * @param string $method 密码规范
     * @return string 密文
     */
    private static function encrypt(String $password,String $iv,String $method = 'AES-256-CBC'){
        $key = Config::get('SYSTEM_KEY');
        return openssl_encrypt($password,$method,$key,0,$iv);
    }

    /**
     * 解密
     * @param String $password 密文
     * @param String $iv 初始化向量
     * @param String $method 密码规范
     * @return string 明文
     */
    private static function decrypt(String $password,String $iv,String $method = 'AES-256-CBC'){
        $key = Config::get('SYSTEM_KEY');
        return openssl_decrypt($password,$method,$key,0,$iv);
    }

    /**
     * 根据密码ID判断密码是否存在
     * @param int $passwordId 密码ID
     * @return bool
     */
    public static function hasExistById(int $passwordId){
        $databaseInstance = Database::getInstance();
        $passwordInfo = $databaseInstance->table('passwd')
            ->where([
                'passwd_id' =>  $passwordId,
                'is_delete' =>  1
            ])->fetch();
        if(!$passwordInfo){
            return false;
        }
        return true;
    }
}