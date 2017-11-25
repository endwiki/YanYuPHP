<?php
/**
 * 创建数据库实例失败
 * User: end_wiki
 * Date: 2017/11/04
 * Time: 14:30
 */
namespace src\framework\exceptions;


class CreateMySQLInstanceFailedException extends ExceptionHandler{

    protected $code = 100023;
    protected $message = '创建 MySQL 数据库实例异常!';

}