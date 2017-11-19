<?php
/**
 * 认证控制器(基类)
 * User: end_wiki
 * Date: 2017/11/5
 * Time: 15:01
 */
namespace app\api\controller;

use app\api\org\Token;
use src\framework\Request;
use app\api\model\User as UserModel;
use app\common\exceptions\GetRequestHeaderFailedException;
use app\common\exceptions\TokenCheckFailedException;


class Authorization {

    protected $uid;

    public function __construct(){
        // 检查用户是否登陆
        $header = Request::getHeader();
        if(!isset($header['Authorization'])){
            throw new GetRequestHeaderFailedException();
        }
        // 获取用户 ID
        $this->uid = Token::checkToken($header['Authorization']);
        if(!$this->uid){
            throw new TokenCheckFailedException();
        }

        return $this->uid;
    }

}