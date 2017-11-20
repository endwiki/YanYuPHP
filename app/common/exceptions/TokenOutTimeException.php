<?php
/**
 * Token 校验超时
 * User: end_wiki
 * Date: 2017/11/4
 * Time: 16:45
 */
namespace app\common\exceptions;

use src\framework\exceptions\ExceptionHandler;

class TokenOutTimeException extends ExceptionHandler{
    protected $code = 200008;
    protected $message = 'Token 校验超时!';
}