<?php
/**
 * IP 不允许访问异常
 * User: end_wiki
 * Date: 2017/11/28
 * Time: 17:58
 */
namespace yanyu\exceptions;

class TheIpDenyPassException extends ExceptionHandler{
    protected $code = 100032;
    protected $message = '您被拒绝访问!';
}