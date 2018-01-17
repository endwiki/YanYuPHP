<?php
/**
 * 类没有找到
 * User: end_wiki
 * Date: 2017/11/24
 * Time: 11:16
 */
namespace yanyu\exceptions;

class ClassNotFoundException extends ExceptionHandler {
    protected $code = 100014;
    protected $message = '类没有找到';
}