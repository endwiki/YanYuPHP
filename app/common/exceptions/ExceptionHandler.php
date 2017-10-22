<?php
/**
 * 异常处理句柄
 * User: end_wiki
 * Date: 2017/10/22
 * Time: 21:35
 */
namespace app\common\exceptions;

use src\framework\Request;
use src\framework\Response;

class ExceptionHandler extends \Exception{

    public function __construct(){
        Response::ajaxReturn([
            'message'       =>      $this->getMessage(),
            'code'          =>      $this->getCode(),
            'url'           =>      Request::getUrl(),
        ]);
    }

}