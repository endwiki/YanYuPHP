<?php
/**
 * 文件夹不存在异常
 * User: end_wiki
 * Date: 2017/11/21
 * Time: 11:23
 */
namespace yanyu\exceptions;

class DirNotMissException extends ExceptionHandler {
    protected $code = 100011;
    protected $message = '文件夹不存在';
}