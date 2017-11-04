<?php
/**
 * 配置类
 * User: end_wiki
 * Date: 2017/10/22
 * Time: 19:55
 */
namespace src\framework;

class Config {

    private static $config;

    // 加载配置
    public static function load($config){
        self::$config = $config;
    }

    // 获取配置
    public static function get($key = null){
        // 如果为空，则返回全部配置
        if(is_null($key)){
            return self::$config;
        }else{
            return (self::$config)[$key];
        }
        return null;
    }

}