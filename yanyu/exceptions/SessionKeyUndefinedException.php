<?php
/**
 * Session 的键未定义异常
 * User: end_wiki
 * Date: 2017/11/29
 * Time: 10:59
 */
namespace yanyu\exceptions;

class SessionKeyUndefinedException extends ExceptionHandler {
    protected $code = 100034;
    protected $message = 'Session 键名尚未定义!';
}