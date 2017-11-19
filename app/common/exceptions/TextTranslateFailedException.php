<?php
/**
 * 翻译失败异常类
 * User: end_wiki
 * Date: 2017/11/19
 * Time: 15:54
 */
namespace app\common\exceptions;

class TextTranslateFailedException extends ExceptionHandler {
    protected $code = 600002;
    protected $message = '翻译失败，请稍后再试!';
}