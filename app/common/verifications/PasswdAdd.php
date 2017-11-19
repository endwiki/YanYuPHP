<?php
/**
 * 密码新增接口检验类
 * User: end_wiki
 * Date: 2017/11/19
 * Time: 20:50
 */
namespace app\common\verifications;

use app\api\model\Passwd;
use src\framework\Validation;

class PasswdAdd extends Validation {
    // 密码名称字段
    protected $title = [
        [
            'require'   =>  true,
            'type'  =>  'String',
            'length'    =>  '1,20',
            'message'   =>  '密码名称在 1 到 20 个字符以内!'
        ],
        [
            'type'  =>  'Method',
            'class' =>  'app\\common\\verifications\\PasswdAdd',
            'method_name'   =>  'titleMustNotExist',
            'injection_args'    =>  ['userId'],
            'message'   =>  '该密码标题已经存在,请更换名称!'
        ]
    ];
    // 密码描述字段
    protected $description = [
        'require'   =>  true,
        'type'  =>  'String',
        'length'    =>  '0,140',
        'message'   =>  '密码描述在 1 到 140 个字符以内!'
    ];

    // 密码字段
    protected $password = [
        'require'   =>  true,
        'type'  =>  'String',
        'length'    =>  '6,32',
        'message'   =>  '密码在 1 到 32 个字符以内!'
    ];

    /**
     * 检验密码标题是否存在
     * @param String $value
     * @param array $injectionArgs
     * @return bool
     */
    public function titleMustNotExist(String $value,array $injectionArgs){
        $result = Passwd::hasExistByTitle($value,$injectionArgs['userId']);
        // 如果存在返回 true,否则返回 false
        return !$result;
    }
}