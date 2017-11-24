<?php
/**
 * 异常处理句柄
 * User: end_wiki
 * Date: 2017/10/22
 * Time: 21:35
 */
namespace src\framework\exceptions;

use src\framework\Request;
use src\framework\Response;

class ExceptionHandler extends \Exception{

    public $url = '';

    public function __construct($code = null,$message = null){
        $this->code = $code;
        $this->message = $message;
        $this->url = Request::getUrl();
    }

}