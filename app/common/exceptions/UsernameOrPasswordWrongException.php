<?php
/**
 * 用户名或密码错误
 * User: end_wiki
 * Date: 2017/11/4
 * Time: 16:09
 */
namespace app\common\exceptions;

class UsernameOrPasswordWrongException extends ExceptionHandler{
    protected $code = 200005;
    protected $message = '用户名或密码错误!';
}