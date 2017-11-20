<?php
/**
 * 注册的用户已经存在
 * User: end_wiki
 * Date: 2017/11/4
 * Time: 15:24
 */
namespace app\common\exceptions;

use src\framework\exceptions\ExceptionHandler;

class RegisteredUserAlreadyExistsException extends ExceptionHandler{
    protected $code = 200003;
    protected $message = '您注册的该用户名已经存在!';
}