<?php
/**
 * 日志文件类型实现类
 * User: end_wiki
 * Date: 2017/11/26
 * Time: 21:35
 */
namespace src\framework\logs;

use src\framework\File as FileClass;
use src\framework\Config;


class File implements LoggerInterface {

    /**
     * 添加日志
     * @param String $data 日志内容
     * @param String $level 日志类型 [RUN|WARRING|ERROR|DATABASE]
     * @param String $namespace 命名空间 default 'Default'
     * @return void
     */
    public function add(String $data,String $level = 'RECORD',String $namespace = 'Default'){
        $content = '[' . Date('Y-m-d H:i:s',time()) . ']' . $namespace . '.' . $level . ':' . $data;
        FileClass::textWrite($content,self::getLogFile(),'a+');
    }

    /**
     * 获取日志文件路径
     * @return String 日志文件路径
     */
    private static function getLogFile(){
        $path = Config::get('SYSTEM_RUNTIME_PATH')  . 'logs/'
            . Date('Y') . '/' . Date('m') . '/' . Date('d') . '/';
        $file = Date('YmdH') . '.log';
        // 判断路径是否存在，不存在则创建
        if(!FileClass::isDirExist($path)){
            FileClass::makeDir($path,true);
        }
        $logFile = $path . $file;
        return $logFile;
    }

    public function get(){

    }
}