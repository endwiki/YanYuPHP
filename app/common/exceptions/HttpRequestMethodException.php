<?php
/**
 * HTTP 请求方法异常
 * User: end_wiki
 * Date: 2017/10/22
 * Time: 21:34
 */
namespace app\common\exceptions;

class HttpRequestMethodException extends ExceptionHandler{

    protected $code = 100001;
    protected $message = '请求方法错误';

}