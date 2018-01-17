<?php
/**
 * 配置没有找到异常
 * User: end_wiki
 * Date: 2017/11/25
 * Time: 17:50
 */
namespace yanyu\exceptions;

class ConfigNotFoundException extends ExceptionHandler {
    protected $code = 100025;
    protected $message = '配置没有找到!';
}