<?php
/**
 * 文件夹已经存在
 * User: end_wiki
 * Date: 2017/11/21
 * Time: 11:17
 */
namespace src\framework\exceptions;

class DirAlreadyExistException extends ExceptionHandler {
    protected $code = 100010;
    protected $message = '文件夹已经存在';
}