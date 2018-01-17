<?php
/**
 * Session 类
 * User: end_wiki
 * Date: 2017/11/29
 * Time: 9:57
 */
namespace yanyu;

use yanyu\exceptions\ConfigNotFoundException;
use yanyu\exceptions\SessionKeyUndefinedException;
use yanyu\exceptions\SessionStartFailedException;

class Session {

    protected static $startFlag;          // 是否已经开启 session

    /**
     * 设置 Session 键值
     * @param String $key Session 键
     * @param String $value Session 键的值
     * @param int $exp 过期时间
     * @throw void
     */
    public static function set(String $key,String $value,$exp = 5){
        !isset(self::$startFlag) && self::start();
        // FIXME: 设置有效期无效
        if(isset($exp)){
            ini_set('session.gc_maxlifetime',$exp);
            ini_set('session.cookie_lifetime',$exp);
        }
        if(strpos($key,'.')){
            list($oneLevel,$twoLevel) = explode('.',$key);
            try{
                $prefix = Config::get('session.prefix');
                $_SESSION[$prefix][$oneLevel][$twoLevel] = $value;
            }catch (ConfigNotFoundException $e){
                $_SESSION[$oneLevel][$twoLevel] = $value;
            }
        }else{
            try{
                $prefix = Config::get('session.prefix');
                $_SESSION[$prefix][$key] = $value;
            }catch (ConfigNotFoundException $e){
                $_SESSION[$key] = $value;
            }
        }
    }

    /**
     * 获取指定 Session 键的值
     * @param String $key Session 键
     * @return null
     * @throws SessionKeyUndefinedException [100034] Session 键名尚未定义异常
     */
    public static function get(String $key){
        !isset(self::$startFlag) && self::start();
        if(strpos($key,'.')){
            list($oneLevel,$twoLevel) = explode('.',$key);
            // 根据前缀返回键值
            try{
                $prefix = Config::get('session.prefix');
                // Session 键名尚未定义
                if(!isset($_SESSION[$prefix][$oneLevel][$twoLevel])){
                    throw new SessionKeyUndefinedException();
                }
                return $_SESSION[$prefix][$oneLevel][$twoLevel];
            }catch (ConfigNotFoundException $e){
                // Session 键名尚未定义
                if(!isset($_SESSION[$oneLevel][$twoLevel])){
                    throw new SessionKeyUndefinedException();
                }
                return $_SESSION[$oneLevel][$twoLevel];
            }
        }else{

            try{
                $prefix = Config::get('session.prefix');
                // Session 键名尚未定义
                if(!isset($_SESSION[$prefix][$key])){
                    throw new SessionKeyUndefinedException();
                }
                return $_SESSION[$prefix][$key];
            }catch (ConfigNotFoundException $e){
                // Session 键名尚未定义
                if(!isset($_SESSION[$key])){
                    throw new SessionKeyUndefinedException();
                }
                return $_SESSION[$key];
            }
        }
        return null;
    }

    /**
     * 判断 Session 指定键是否存在
     * @param String $key Session 键
     * @return bool
     */
    public static function hasExist(String $key){
        !isset(self::$startFlag) && self::start();
        if(strpos($key,'.')){
            list($oneLevel,$twoLevel) = explode('.',$key);
            $prefix = '';           // 前缀
            try{
                $prefix = Config::get('session.prefix');
                return (isset($_SESSION[$oneLevel][$twoLevel]));
            }catch (ConfigNotFoundException $e){
                return (isset($_SESSION[$prefix][$oneLevel][$twoLevel]));
            }
        }
        return false;
    }

    /**
     * 开启会话
     * @param array|null $option 会话配置选项
     * @throws SessionStartFailedException [100033]Session 启动失败异常
     */
    public static function start(array $option = null){
        // 启动 session
        if(session_status() != PHP_SESSION_ACTIVE){
            if(!is_null($option)){
                $result = session_start($option);
            }else{
                $result = session_start();
            }
            if(!$result){
                throw new SessionStartFailedException();
            }
        }
        self::$startFlag = true;
    }

    /**
     * 清空 Session
     * @param String $key Session 键
     * @return void
     */
    public static function clear(String $key = null){
        $prefix = '';           // 前缀
        try{
            $prefix = Config::get('session.prefix');
            if(is_null($key)){
                unset($_SESSION[$prefix]);
                return ;
            }
            if(strpos($key,'.')){
                unset($_SESSION[$prefix][(explode('.',$key))[0]]);
                return ;
            }
            unset($_SESSION[$prefix][$key]);
        }catch (ConfigNotFoundException $e){
            // Session 键名尚未定义
            if(is_null($key)){
                $_SESSION = [];
                return ;
            }
            if(strpos($key,'.')){
                unset($_SESSION[(explode('.',$key))[0]]);
                return ;
            }
            unset($_SESSION[$key]);
        }
    }
}