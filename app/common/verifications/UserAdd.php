<?php
/**
 * 新增用户接口验证类
 * User: end_wiki
 * Date: 2017/11/8
 * Time: 16:29
 */
namespace app\common\verifications;

use src\framework\Validation;

class UserAdd extends Validation{
    protected $username = [
        'require'   =>  true,
        'type'      =>  'string',
        'length'    =>  '1,20',
        'message'   =>  '用户名必须在 1 到 20 个字符以内',
    ];
    protected $password = [
        'require'   =>  true,
        'type'      =>  'string',
        'length'    =>  '8,24',
        'message'   =>  '密码必须在 8 到 24 个字符以内',
    ];
}