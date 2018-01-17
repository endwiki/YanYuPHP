<?php
/**
 * MySQL 执行失败异常
 * User: end_wiki
 * Date: 2017/11/24
 * Time: 9:57
 */
namespace yanyu\exceptions;

class DatabaseExecuteFailedException extends ExceptionHandler {
    protected $code = 100012;
    protected $message = 'MySQL 执行失败!';
}