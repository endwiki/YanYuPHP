<?php
/**
 * 没有找到对应的验证类型
 * User: end_wiki
 * Date: 2017/11/7
 * Time: 20:50
 */
namespace app\common\exceptions;

use src\framework\exceptions\ExceptionHandler;

class VerifyTypeNotFoundException extends ExceptionHandler{
    protected $code = 100004;
    protected $message = '没有找到对应的验证方法!';
}