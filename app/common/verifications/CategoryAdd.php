<?php
/**
 * 类目校验类
 * User: end_wiki
 * Date: 2017/11/5
 * Time: 22:10
 */
namespace app\common\verifications;

use src\framework\Validation;

class CategoryAdd extends Validation{
    protected $name = [
        'require'       =>      true,
        'type'          =>      'string',
        'length'        =>      '1,20',
        'message'       =>      '文章类目为 1 到 15 个汉字'
    ];
}