<?php
/**
 * 缓存类
 * User: end_wiki
 * Date: 2017/11/24
 * Time: 10:26
 */
namespace yanyu;

use yanyu\exceptions\CacheTypeNotFoundException;
use \yanyu\exceptions\ClassNotFoundException;

class Cache {

    protected static $namespace = 'src\\framework\\caches\\';        // 命名空间
    protected static $instance;                                      // 保存实例
    protected static $i;

    /**
     * 获取缓存实例
     * @throws CacheTypeNotFoundException [100015]缓存方式不存在异常
     * @return self::$instance
     */
    public static function getInstance(){
        self::$i++;
        if(self::$i == 2){
            debug_print_backtrace();
            die();
        }

        $cacheType = Config::get('CACHE.TYPE');
        $className = self::$namespace . ucfirst(strtolower($cacheType));
        if(!isset(self::$instance)){
            try{
                self::$instance = new $className;
            }catch(ClassNotFoundException $e){
                throw new CacheTypeNotFoundException();
            }
        }
        return self::$instance;
    }

    /**
     * 设置缓存
     * @param String $key 键名
     * @param String $value 值
     * @return mixed
     */
    public static function set(String $key,String $value){
        if(!isset(self::$instance)){
            self::getInstance();
        }
        $result = self::$instance->set($key,$value,Config::get('CACHE.EXPIRATION'));
        return $result;
    }

    public static function get(String $key){
        if(!isset(self::$instance)){
            self::getInstance();
        }
        $value = self::$instance->get($key);
        return $value;
    }
}