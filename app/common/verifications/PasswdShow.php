<?php
/**
 * 密码显示接口检验类
 * User: end_wiki
 * Date: 2017/11/19
 * Time: 21:08
 */
namespace app\common\verifications;

use app\api\model\Passwd;
use src\framework\Validation;

class PasswdShow extends Validation{
    // 密码 ID 字段
    protected $password_id = [
        'require'   =>  true,
        'type'      =>  'Method',
        'class'     =>  'app\\common\\verifications\\PasswdShow',
        'method_name'   =>  'passwordMustExist',
        'message'   =>  '密码必须存在!',
    ];

    /**
     * 检验密码是否存在
     * @param int $passwordId 密码 ID
     * @return bool
     */
    public function passwordMustExist(Int $passwordId){
        return Passwd::hasExistById($passwordId);
    }

}