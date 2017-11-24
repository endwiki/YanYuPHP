<?php
/**
 * 配置类
 * User: end_wiki
 * Date: 2017/10/22
 * Time: 19:55
 */
namespace src\framework;

use src\framework\exceptions\ConfigParametersNotMatchException;

class Config {

    private static $config;

    // 加载配置
    public static function load($config){
        self::$config = $config;
    }

    /**
     * 读取配置
     * @param String $key 配置索引
     * @return mixed
     * @throws ConfigParametersNotMatchException [100013]读取配置时参数个数不匹配
     */
    public static function get(String $key){
        // 二层配置读取
        if(strpos($key,'.')){
            $level = explode('.',$key);
            if(count($level) > 2){
                throw new ConfigParametersNotMatchException();
            }
            list($oneLevel,$twoLevel) = explode('.',$key);

            return self::$config[$oneLevel][$twoLevel];
        }
        // 返回单层配置
        return (self::$config)[$key];
    }

}