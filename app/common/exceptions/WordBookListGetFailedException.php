<?php
/**
 * 获取单词本列表异常
 * User: end_wiki
 * Date: 2017/11/19
 * Time: 16:56
 */
namespace app\common\exceptions;

use src\framework\exceptions\ExceptionHandler;

class WordBookListGetFailedException extends ExceptionHandler {
    protected $code = 500002;
    protected $message = '获取单词本列表无失败!';
}