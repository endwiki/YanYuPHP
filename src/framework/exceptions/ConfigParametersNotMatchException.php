<?php
/**
 * 读取配置参数不匹配异常
 * User: end_wiki
 * Date: 2017/11/24
 * Time: 10:44
 */
namespace src\framework\exceptions;

class ConfigParametersNotMatchException extends ExceptionHandler {
    protected $code = 100013;
    protected $message = '读取参数时的参数不匹配!';
}
