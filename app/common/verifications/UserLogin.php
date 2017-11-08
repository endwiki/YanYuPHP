<?php
/**
 * 新增用户接口验证类
 * User: end_wiki
 * Date: 2017/11/8
 * Time: 16:29
 */
namespace app\common\verifications;

use src\framework\Validation;

class UserLogin extends Validation{
    protected $username = [
        'require'   =>  true,
        'type'      =>  'string',
        'length'    =>  '1,20',
        'message'   =>  '用户名密码错误!',
    ];
    protected $password = [
        'require'   =>  true,
        'type'      =>  'string',
        'length'    =>  '8,24',
        'message'   =>  '用户名密码错误!',
    ];
}