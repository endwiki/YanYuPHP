<?php
/**
 * 路由方法不匹配
 * User: end_wiki
 * Date: 2017/11/24
 * Time: 16:51
 */
namespace yanyu\exceptions;

class RouteMethodNotMatchException extends ExceptionHandler {
    protected $code = 100018;
    protected $message = '路由方法不匹配!';
}