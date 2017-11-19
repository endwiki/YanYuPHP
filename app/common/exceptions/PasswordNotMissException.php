<?php
/**
 * 密码不存在异常
 * User: end_wiki
 * Date: 2017/11/19
 * Time: 20:49
 */
namespace app\common\exceptions;

class PasswordNotMissException extends ExceptionHandler{
    protected $code = 700002;
    protected $message = '密码不存在!';
}