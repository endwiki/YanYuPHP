<?php
/**
 * Cookie 类
 * User: end_wiki
 * Date: 2017/11/27
 * Time: 14:10
 */
namespace yanyu;

use yanyu\exceptions\ConfigNotFoundException;
use yanyu\exceptions\CookieConfigUndefinedException;

class Cookie {

    protected static $config;       // 配置
    protected static $prefix;       // 前缀
    protected static $hasInit;      // 初始化旗标

    /**
     * 初始化配置
     * @return void
     */
    public static function init(){
        $config = self::getConfig();
        // 该配置用以防止 XSS 攻击
        if($config['HTTP_ONLY']){
            ini_set('session.cookie_httponly',1);
        }
        self::$hasInit = true;
    }

    /**
     * 设置 Cookie
     * @param String $key Cookie 键
     * @param String $value Cookie 值
     * @return void
     */
    public static function set(String $key,String $value){
        // 初始化
        !isset(self::$hasInit) && self::init();
        // 设置前缀
        if(isset(self::$config['PREFIX'])){
            $key = self::$config['PREFIX'] . $key;
        }
        // 过期时间
        $expire = !empty(self::$config['EXPIRE']) ? $_SERVER['REQUEST_TIME'] + intval(self::$config) : 0;
        // 设置 Cookie
        if(!self::$config['SET_COOKIE']){
            setcookie($key,$value,$expire);
        }
        $_COOKIE[$key] = $value;
    }

    /**
     * 检查指定 Cookie 是否存在
     * @param String $key Cookie 键
     * @return bool
     */
    public static function hasExist(String $key){
        // 初始化
        !isset(self::$hasInit) && self::init();
        // 设置前缀
        if(isset(self::$config['PREFIX'])){
            $key = self::$config['PREFIX'] . $key;
        }
        return (isset($_COOKIE[$key]));
    }

    /**
     * 获取 Cookie
     * @param String $key Cookie 键
     * @return string
     */
    public static function get(String $key){
        // 初始化
        !isset(self::$hasInit) && self::init();
        // 设置前缀
        if(isset(self::$config['PREFIX'])){
            $key = self::$config['PREFIX'] . $key;
        }
        if(isset($_COOKIE[$key])){
            return $_COOKIE[$key];
        }
        return '';
    }

    /**
     * 获取 Cookie 配置
     * @return mixed
     * @throws CookieConfigUndefinedException [100031]Cookie 配置未定义异常
     */
    protected static function getConfig(){
        if(isset(self::$config)){
            try{
                self::$config = Config::get('COOKIE');
            }catch (ConfigNotFoundException $e){
                throw new CookieConfigUndefinedException();
            }
        }
        return self::$config;
    }
}