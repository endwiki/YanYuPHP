<?php
/**
 * 无效的方法调用异常
 * User: end_wiki
 * Date: 2017/11/26
 * Time: 1:39
 */
namespace yanyu\exceptions;

class CalledMethodInvalidException extends ExceptionHandler {
    protected $code = 100028;
    protected $message = '无效的方法调用!';
}