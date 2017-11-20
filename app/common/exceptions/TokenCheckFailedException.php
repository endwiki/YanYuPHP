<?php
/**
 * Token 校验失败异常
 * User: end_wiki
 * Date: 2017/11/4
 * Time: 16:42
 */
namespace app\common\exceptions;

use src\framework\exceptions\ExceptionHandler;

class TokenCheckFailedException extends ExceptionHandler{
    protected $code = 200007;
    protected $message = 'Token 校验失败!';
}