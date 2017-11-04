<?php
/**
 * 用户注册失败异常
 * User: end_wiki
 * Date: 2017/11/4
 * Time: 15:45
 */
namespace app\common\exceptions;

class UserRegistrationFailedException extends ExceptionHandler{
    protected $code = 200004;
    protected $message = '注册发生了意外,请联系系统管理方!';
}