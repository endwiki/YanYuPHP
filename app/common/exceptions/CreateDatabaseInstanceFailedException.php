<?php
/**
 * 创建数据库实例失败
 * User: end_wiki
 * Date: 2017/11/04
 * Time: 14:30
 */
namespace app\common\exceptions;

class CreateDatabaseInstanceFailedException extends ExceptionHandler{

    protected $code = 300001;
    protected $message = '创建数据库实例失败!';

}