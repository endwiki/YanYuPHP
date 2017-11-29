<?php
/**
 * Session 启动失败异常
 * User: end_wiki
 * Date: 2017/11/29
 * Time: 10:17
 */
namespace src\framework\exceptions;

class SessionStartFailedException extends ExceptionHandler {
    protected $code = 100033;
    protected $message = 'Session 启动失败!';
}