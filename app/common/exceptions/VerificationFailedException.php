<?php
/**
 * 校验错误
 * User: end_wiki
 * Date: 2017/11/5
 * Time: 15:43
 */
namespace app\common\exceptions;

use src\framework\exceptions\ExceptionHandler;

class VerificationFailedException extends ExceptionHandler{
    protected $code = 100003;
    protected $message = '参数校验错误!';
}