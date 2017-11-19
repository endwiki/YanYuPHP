<?php
/**
 * 密码接口
 * User: end_wiki
 * Date: 2017/11/19
 * Time: 19:50
 */
namespace app\api\controller;

use app\common\exceptions\PassWordAddFailedException;
use app\common\verifications\PasswdAdd;
use app\common\verifications\PasswdShow;
use src\framework\Config;
use app\api\model\Passwd as PasswdModel;
use src\framework\Request;
use src\framework\Response;

class Passwd extends Authorization {

    /**
     * 新增密码
     * @method POST
     * @api api/passwd/add
     * @throws PassWordAddFailedException [700001]密码新增失败
     * @return mixed
     */
    public function add(){
        $params = Request::post();
        $params['userId'] = $this->uid;
        (new PasswdAdd())->eachFields($params);

        $result = PasswdModel::addPasswd($params['title'],$params['description'],
            $params['password'],$this->uid);
        if(!$result){
            throw new PassWordAddFailedException();
        }
        Response::ajaxReturn([
            'code'  =>  1,
            'message'   =>  '密码保存成功!',
        ]);
    }

    /**
     * 显示密码
     * @method GET
     * @api api/passwd/show
     * @return mixed
     */
    public function show(){
        $params = Request::get();
        (new PasswdShow())->eachFields($params);

        $password = PasswdModel::getPasswd($params['password_id']);
        Response::ajaxReturn([
            'code'  =>  1,
            'data'  =>  $password,
            'message'   =>  '获取密码成功!',
        ]);
    }
}