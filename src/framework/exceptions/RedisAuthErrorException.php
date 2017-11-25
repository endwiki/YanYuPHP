<?php
/**
 * Redis 密码错误异常
 * User: end_wiki
 * Date: 2017/11/26
 * Time: 1:05
 */
namespace src\framework\exceptions;

class RedisAuthErrorException extends ExceptionHandler {
    protected $code = 100027;
    protected $message = 'Redis 服务器认证失败:密码错误!';
}