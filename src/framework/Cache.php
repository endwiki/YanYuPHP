<?php
/**
 * 缓存类
 * User: end_wiki
 * Date: 2017/11/24
 * Time: 10:26
 */
namespace src\framework;

use src\framework\exceptions\CacheTypeNotFoundException;
use \src\framework\exceptions\ClassNotFoundException;

class Cache {

    protected static $namespace = 'src\\framework\\caches\\';        // 命名空间
    protected static $instance;                                      // 保存实例

    /**
     * 获取缓存实例
     * @throws CacheTypeNotFoundException [100015]缓存方式不存在异常
     * @return self::$instance
     */
    public static function getInstance(){
        $cacheType = (Config::get('CACHE.TYPE'));
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
}