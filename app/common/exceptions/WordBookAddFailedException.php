<?php
/**
 * 添加单词本失败异常
 * User: end_wiki
 * Date: 2017/11/19
 * Time: 0:43
 */
namespace app\common\exceptions;

use src\framework\exceptions\ExceptionHandler;

class WordBookAddFailedException extends ExceptionHandler{
    protected $code = 500001;
    protected $message = '添加单词本失败,请稍后再试!';
}