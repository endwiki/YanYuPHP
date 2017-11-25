<?php
/**
 * Redis 连接异常
 * User: end_wiki
 * Date: 2017/11/26
 * Time: 0:51
 */
namespace src\framework\exceptions;

class RedisConnectFailedException extends ExceptionHandler {
    protected $code = 100026;
    protected $message = 'Redis 连接发生异常!';
}