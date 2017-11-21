<?php
/**
 * 日志记录类
 * User: end_wiki
 * Date: 2017/11/21
 * Time: 16:34
 */
namespace src\framework;

class Logger {

    /**
     * 添加日志
     * @param array $data 日志内容
     * @param String $type 日志类型 [RUN|WARRING|ERROR|DATABASE]
     * @return void
     */
    public static function add(array $data,String $type = 'RUN'){
        array_unshift($data,'Time:' . time());
        array_unshift($data,'Type:' . $type);
        array_push($data,'----------------------');
        File::textWrite($data,self::getLogFile(),'a+');
    }

    /**
     * 获取日志文件路径
     * @return String 日志文件路径
     */
    private static function getLogFile(){
        $logFile = Config::get('SYSTEM_RUNTIME_PATH')  . 'logs/'
            . Date('Y') . '/' . Date('m') . '/' . Date('d') . '/'
            . Date('YmdH') . '.log';
        return $logFile;
    }
}