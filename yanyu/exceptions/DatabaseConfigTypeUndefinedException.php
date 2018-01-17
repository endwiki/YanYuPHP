<?php
/**
 * 数据库配置数据库类型未定义异常
 * User: end_wiki
 * Date: 2017/11/27
 * Time: 10:17
 */
namespace yanyu\exceptions;

class DatabaseConfigTypeUndefinedException extends ExceptionHandler {
    protected $code = 100030;
    protected $message = '数据库配置文件中数据库类型为定义!';
}