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
        if(!is_null($code)){
            $this->code = $code;
        }else{
            $this->code = $this->getCode();
        }
        if(!is_null($message)){
            $this->message = $message;
        }else{
            $this->message = $this->getMessage();
        }
        $this->url = Request::getUrl();
    }

}