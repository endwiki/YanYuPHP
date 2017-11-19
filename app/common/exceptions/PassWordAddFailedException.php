<?php
/**
 * 密码新增失败异常
 * User: end_wiki
 * Date: 2017/11/19
 * Time: 20:45
 */
namespace app\common\exceptions;

class PassWordAddFailedException extends ExceptionHandler {
    protected $code = 700001;
    protected $message = '密码新增失败!';
}