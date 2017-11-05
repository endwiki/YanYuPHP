<?php
/**
 * 类目名称已经存在异常
 * User: end_wiki
 * Date: 2017/11/5
 * Time: 22:49
 */
namespace app\common\exceptions;

class CategoryNameAlreadyExistException extends ExceptionHandler {
    protected $code = 400002;
    protected $message = '您指定的类目名称已经存在!';
}