<?php
/**
 * 路由方法不存在
 * User: end_wiki
 * Date: 2017/11/24
 * Time: 16:35
 */
namespace src\framework\exceptions;

class RouteMethodNotFoundException extends ExceptionHandler {
    protected $code = 1000017;
    protected $message = '路由方法不存在!';
}