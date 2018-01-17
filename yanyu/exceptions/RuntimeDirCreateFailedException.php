<?php
/**
 * 运行时目录创建失败异常
 * User: end_wiki
 * Date: 2017/11/21
 * Time: 16:17
 */
namespace yanyu\exceptions;

class RuntimeDirCreateFailedException extends ExceptionHandler {
    protected $code = 100012;
    protected $message = '临时目录创建失败，请确认是否相应权限!';
}