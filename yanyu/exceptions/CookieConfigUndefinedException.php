<?php
/**
 * Cookie 配置未定义异常
 * User: end_wiki
 * Date: 2017/11/27
 * Time: 14:15
 */
namespace yanyu\exceptions;

class CookieConfigUndefinedException extends ExceptionHandler{
    protected $code = 100031;
    protected $message = 'Cookie 配置未定义!';
}