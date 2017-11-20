<?php
/**
 * 密码没有填写异常
 * User: end_wiki
 * Date: 2017/11/04
 * Time: 14:30
 */
namespace app\common\exceptions;

use src\framework\exceptions\ExceptionHandler;

class PasswordHasRequireException extends ExceptionHandler{

    protected $code = 200003;
    protected $message = '密码必填!';

}