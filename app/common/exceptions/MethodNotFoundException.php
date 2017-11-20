<?php
/**
 * 成员方法没有找到异常
 * User: end_wiki
 * Date: 2017/11/7
 * Time: 23:01
 */
namespace app\common\exceptions;

use src\framework\exceptions\ExceptionHandler;

class MethodNotFoundException extends ExceptionHandler{
    protected $code = 100006;
    protected $message = '成员方法没有找到!';
}