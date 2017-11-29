<?php
/**
 * 发送短信失败
 * User: end_wiki
 * Date: 2017/11/28
 * Time: 17:20
 */
namespace app\common\exceptions;

use src\framework\exceptions\ExceptionHandler;

class SendSMSFailedException extends ExceptionHandler{
    protected $code = 600001;
    protected $message = '发送短信失败!';
}