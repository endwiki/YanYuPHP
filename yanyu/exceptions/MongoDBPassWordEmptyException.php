<?php
/**
 * MongoDB 密码为空异常
 * User: end_wiki
 * Date: 2017/11/26
 * Time: 4:01
 */
namespace yanyu\exceptions;

class MongoDBPassWordEmptyException extends ExceptionHandler {
    protected $code = 100029;
    protected $message = 'MongoDB 密码配置不能为空!';
}