<?php
/**
 * 请求的控制器不存在异常
 * User: end_wiki
 * Date: 2017/11/25
 * Time: 15:13
 */
namespace yanyu\exceptions;

class RequestControllerNotFoundException extends ExceptionHandler {
    protected $code = 100020;
    protected $message = '请求的控制器不存在!';
}