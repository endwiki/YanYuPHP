<?php
/**
 * 请求的操作不存在异常
 * User: end_wiki
 * Date: 2017/11/25
 * Time: 14:34
 */
namespace src\framework\exceptions;

class RequestActionNotFoundException extends ExceptionHandler {
    protected $code = 100019;
    protected $message = '请求的操作不存在!';
}