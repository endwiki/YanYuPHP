<?php
/**
 * 类没有找到异常
 * User: end_wiki
 * Date: 2017/11/7
 * Time: 22:59
 */
namespace app\common\exceptions;

use src\framework\exceptions\ExceptionHandler;

class ClassNotFoundException extends ExceptionHandler{
    protected $code = 100006;
    protected $message = '类没有找到!';
}