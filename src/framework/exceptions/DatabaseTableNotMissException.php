<?php
/**
 * 数据库数据表没有找到异常
 * User: end_wiki
 * Date: 2017/11/20
 * Time: 14:21
 */
namespace src\framework\exceptions;

class DatabaseTableNotMissException extends ExceptionHandler {
    protected $code = 100007;
    protected $message = '数据库数据表没有找到!';
}