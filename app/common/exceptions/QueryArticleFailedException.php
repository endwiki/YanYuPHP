<?php
/**
 * 查询文章失败
 * User: end_wiki
 * Date: 2017/11/8
 * Time: 17:52
 */
namespace app\common\exceptions;

class QueryArticleFailedException extends ExceptionHandler{
    protected $code = 300002;
    protected $message = '查询文章的过程中发生异常!';
}