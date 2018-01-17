<?php
/**
 * 路由规则没有找到异常
 * User: end_wiki
 * Date: 2017/11/24
 * Time: 16:20
 */
namespace yanyu\exceptions;

class RouteRuleNotMissException extends ExceptionHandler {
    protected $code = 100016;
    protected $message = '路由规则不匹配!';
}