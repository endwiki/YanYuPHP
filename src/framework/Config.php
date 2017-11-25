<?php
/**
 * 配置类
 * User: end_wiki
 * Date: 2017/10/22
 * Time: 19:55
 */
namespace src\framework;

use src\framework\exceptions\DefaultConfigFileNotFoundException;
use src\framework\exceptions\ConfigParametersNotMatchException;

class Config {

    private static $config = [];

    /**
     * 自动加载配置目录下所有配置文件
     * @return void
     * @throws DefaultConfigFileNotFoundException [100022]默认配置文件不存在异常
     */
    public static function loadAll(){
        // 加载默认配置文件
        $defaultConfigFileName = APP_PATH . '/' . 'Config.php';
        if(!is_file($defaultConfigFileName)){
            throw new DefaultConfigFileNotFoundException();
        }
        self::$config['DEFAULT'] = include $defaultConfigFileName;
        // 自动加载配置
        if(isset(self::$config['DEFAULT']['AUTO_LOAD_CONFIG_DIR'])){
            $autoLoadConfigDir = realpath(self::$config['DEFAULT']['AUTO_LOAD_CONFIG_DIR']);
            $files = File::eachDir($autoLoadConfigDir);
            foreach($files as $file){
                self::$config[strtoupper(pathinfo($file,PATHINFO_FILENAME))] =
                    include_once  $autoLoadConfigDir . '/' . $file;
            }
        }
    }

    /**
     * 读取配置
     * @param String $key 配置索引
     * @param String $prefix 配置前缀
     * @return mixed
     * @throws ConfigParametersNotMatchException [100013]读取配置时参数个数不匹配
     */
    public static function get(String $key,String $prefix = 'DEFAULT'){
        // 二层配置读取
        if(strpos($key,'.')){
            $level = explode('.',$key);
            if(count($level) > 2){
                throw new ConfigParametersNotMatchException();
            }
            list($oneLevel,$twoLevel) = explode('.',$key);

            return self::$config[$prefix][$oneLevel][$twoLevel];
        }
        // 返回单层配置
        return (self::$config)[$prefix][$key];
    }

}