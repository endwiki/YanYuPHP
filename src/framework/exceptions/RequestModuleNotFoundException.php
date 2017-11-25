<?php
/**
 * 请求的模块不存在异常
 * User: end_wiki
 * Date: 2017/11/25
 * Time: 15:21
 */
namespace src\framework\exceptions;

class RequestModuleNotFoundException extends ExceptionHandler {
    protected $code = 100021;
    protected $message = '请求的模块不存在!';
}