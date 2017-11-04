<?php
/**
 * Restful 控制器(父类)
 * User: end_wiki
 * Date: 2017/10/22
 * Time: 21:15
 */
namespace app\api\controller;

use src\framework\Request;
use src\framework\Route;
use app\common\exceptions\HttpRequestMethodException;

class Restful {

    private $actionMethodMap = [
        'add'       =>              'post',
        'update'    =>              'put',
        'delete'    =>              'delete',
        'get'       =>              'get',
    ];

    public function __construct(){
        // 检查 HTTP 方法
        if(strtolower(Request::getMethod()) !==
            strtolower($this->actionMethodMap[Route::getAction()])){
            throw new HttpRequestMethodException();
        }
    }
}
