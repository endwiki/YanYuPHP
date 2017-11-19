<?php
/**
 * 用户接口
 * User: end_wiki
 * Date: 2017/10/22
 * Time: 21:13
 */
namespace app\api\controller;

use app\common\verifications\UserAdd;
use app\common\verifications\UserLogin;
use src\framework\Request;
use src\framework\Response;
use app\api\org\Token;
use app\api\model\User as UserModel;
use app\common\exceptions\UserRegistrationFailedException;
use app\common\exceptions\UsernameOrPasswordWrongException;
use app\common\exceptions\UserNotExistException;



class User  {

    /**
     * 用户注册
     * @method POST
     * @api api/User/add
     * @throws UserRegistrationFailedException
     * @return mixed
     */
    public function add(){
        $params = Request::post();
        // 校验参数
        (new UserAdd())->eachFields($params);
        $result = UserModel::addUser($params['username'],$params['password']);
        if(!$result){
            throw new UserRegistrationFailedException();
        }
        Response::ajaxReturn(['code'=>200000,'message'=>'恭喜您,注册成功!']);
    }

    /**
     * 用户登陆
     * @throws PasswordHasRequireException
     * @throws UserNotExistException
     * @throws UsernameHasRequireException
     * @throws UsernameOrPasswordWrongException
     * @return mixed
     */
    public function login(){
        $params = Request::post();
        // 校验参数
        (new UserLogin())->eachFields($params);

        // 检查用户是否存在
        $userInfo = UserModel::hasExistByUsername($params['username']);
        if(!$userInfo){
            throw new UserNotExistException();
        }

        // 校验用户名和密码
        if(false == password_verify($params['password'],$userInfo['password'])){
            throw new UsernameOrPasswordWrongException();
        }

        // 分发 Token
        $token = Token::createToken($userInfo['user_id']);
        Response::ajaxReturn([
            'code'      =>      210000,
            'msg'       =>      '恭喜您,登陆成功!',
            'token'     =>      $token,
        ]);
    }

}