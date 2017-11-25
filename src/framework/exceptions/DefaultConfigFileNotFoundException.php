<?php
/**
 * 通用配置文件不存在异常
 * User: end_wiki
 * Date: 2017/11/25
 * Time: 16:32
 */
namespace src\framework\exceptions;

class CommonConfigFileNotFoundException extends ExceptionHandler {
    protected $code = 100022;
    protected $message = '通用配置文件不存在!';
}