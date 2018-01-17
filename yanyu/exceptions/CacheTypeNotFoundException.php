<?php
/**
 * 缓存方式不存在
 * User: end_wiki
 * Date: 2017/11/24
 * Time: 11:23
 */
namespace yanyu\exceptions;

class CacheTypeNotFoundException extends ExceptionHandler {
    protected $code = 100015;
    protected $message = '缓存类型不存在!';
}