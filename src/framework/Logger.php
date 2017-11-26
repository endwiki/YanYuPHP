<?php
/**
 * 日志记录类
 * User: end_wiki
 * Date: 2017/11/21
 * Time: 16:34
 */
namespace src\framework;

use src\framework\exceptions\CalledMethodInvalidException;

class Logger {

    public $instance;
    public $namespace = '\\src\\framework\\logs\\';

    /**
     * 调用日志实现类的方法
     * @param String $name 实现类方法名
     * @param array $arguments 实现类参数数组
     * @return mixed
     * @throws CalledMethodInvalidException [100028]调用了不存在的方法
     */
    public function __call(String $name, array $arguments){
        // 获取日志类型配置
        $logType = Config::get('LOG.TYPE','DEFAULT');
        // 日志类型对应类名
        $className = $this->namespace . ucfirst(strtolower($logType));
        // 如果不存在实例，则实例化
        if(!isset($this->instance)){
            $this->instance = new $className();
        }
        // 执行方法
        try{
            $result = $this->instance->$name($arguments[0],$arguments[1]);
        }catch (Error $e){
            throw new CalledMethodInvalidException();
        }
        return $result;
    }

}