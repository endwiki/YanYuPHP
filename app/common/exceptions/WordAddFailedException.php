<?php
/**
 * 单词新增失败异常
 * User: end_wiki
 * Date: 2017/11/19
 * Time: 1:30
 */
namespace app\common\exceptions;

class WordAddFailedException extends ExceptionHandler{
    protected $code = 600001;
    protected $message = '添加单词失败,请稍后再试!';
}