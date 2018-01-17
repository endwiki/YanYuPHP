<?php
/**
 * 数据库配置没有找到异常
 * User: end_wiki
 * Date: 2017/11/25
 * Time: 17:55
 */
namespace yanyu\exceptions;

class DatabaseConfigNotFoundException extends ExceptionHandler{
    protected $code = 100026;
    protected $message = '没有找到对应的数据库配置!';
}