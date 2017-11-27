<?php
/**
 * 日志接口类
 * User: end_wiki
 * Date: 2017/11/26
 * Time: 21:36
 */
namespace src\framework\logs;

interface LoggerInterface {

    // 写入日志
    public function add(String $data,String $type,String $namespace);

    // 读取日志
    public function get();
}