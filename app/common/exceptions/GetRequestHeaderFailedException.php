<?php
/**
 * 获取 HTTP 请求头异常
 * User: end_wiki
 * Date: 2017/11/5
 * Time: 14:56
 */
namespace app\common\exceptions;

class GetRequestHeaderFailedException extends ExceptionHandler{
    protected $code = 100002;
    protected $message = '获取 HTTP 信息发生错误!';
}