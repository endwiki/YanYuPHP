<?php
/**
 * 数据库插入数据为空异常
 * User: end_wiki
 * Date: 2017/11/20
 * Time: 15:56
 */
namespace src\framework\exceptions;

class DatabaseInsertDataHasEmptyException extends ExceptionHandler {
    protected $code = 100009;
    protected $message = '插入数据库的数据不能为空!';
}