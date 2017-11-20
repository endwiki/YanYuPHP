<?php
/**
 * 类目新增失败异常
 * User: end_wiki
 * Date: 2017/11/5
 * Time: 22:37
 */
namespace app\common\exceptions;

use src\framework\exceptions\ExceptionHandler;

class AddCategoryAlreadyFailedException extends ExceptionHandler{
    protected $code = 400001;
    protected $message = '不好意思,类目新增过程中出现了意外!';
}