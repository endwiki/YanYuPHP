<?php
/**
 * 数据库关联语句类型没有找到异常
 * User: end_wiki
 * Date: 2017/11/20
 * Time: 15:04
 */
namespace src\framework\exceptions;

class DatabaseJoinTypeNotMissException extends ExceptionHandler{
    protected $code = 100008;
    protected $message = '数据库关联语句类型没有找到异常';
}