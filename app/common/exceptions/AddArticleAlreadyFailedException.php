<?php
/**
 * 文章新增失败异常
 * User: end_wiki
 * Date: 2017/11/5
 * Time: 17:33
 */
namespace app\common\exceptions;

class AddArticleAlreadyFailedException extends ExceptionHandler{
    protected $code = 300001;
    protected $message = '不好意思,文章发布的过程中出现错误,请稍后再试!';
}