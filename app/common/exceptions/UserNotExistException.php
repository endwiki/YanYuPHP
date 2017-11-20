<?php
/**
 * 用户不存在异常
 * User: end_wiki
 * Date: 2017/11/4
 * Time: 16:15
 */
namespace app\common\exceptions;

use src\framework\exceptions\ExceptionHandler;

class UserNotExistException extends ExceptionHandler{
    protected $code = 200006;
    protected $message = '用户名或密码错误!';
}