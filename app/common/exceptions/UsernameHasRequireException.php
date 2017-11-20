<?php
/**
 * HTTP 请求方法异常
 * User: end_wiki
 * Date: 2017/10/22
 * Time: 21:34
 */
namespace app\common\exceptions;

use src\framework\exceptions\ExceptionHandler;

class UsernameHasRequireException extends ExceptionHandler{

    protected $code = 200001;
    protected $message = '用户名必填!';

}