<?php
/**
 * 缓存-Redis 实现类
 * User: end_wiki
 * Date: 2017/12/9
 * Time: 11:44
 */
namespace yanyu\caches;

use yanyu\Config;
use yanyu\Database;

class Redis {

    protected $instance;


    public function __construct(){
        $this->instance = Database::getInstance(Config::get('CACHE.INSTANCE_NAME'));
    }

    /**
     * 获取缓存
     * @param String $key 键名
     * @return mixed
     */
    public function get(String $key){
        $result = $this->instance->get($key);
        return $result;
    }

    /**
     * 设置缓存
     * @param String $key 键名
     * @param String $value 值
     * @param int $timeout 生存时间(秒)
     * @return mixed
     */
    public function set(String $key,String $value,int $timeout){
        $result = $this->instance->set($key,$value,$timeout);
        return $result;
    }
}