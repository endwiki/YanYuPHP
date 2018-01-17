<?php
/**
 * 数据库类型不支持异常
 * User: end_wiki
 * Date: 2017/11/25
 * Time: 17:45
 */
namespace yanyu\exceptions;

class DatabaseTypeNotFoundException extends ExceptionHandler {
    protected $code = 100024;
    protected $message = '数据库类型不支持!';
}