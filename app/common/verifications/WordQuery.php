<?php
/**
 * 翻译查询接口校验类
 * User: end_wiki
 * Date: 2017/11/19
 * Time: 15:44
 */
namespace app\common\verifications;

use src\framework\Validation;

class WordQuery extends Validation {
    // 将要翻译的文本
    protected $from_text = [
        'require'   =>  true,
        'type'      =>  'String',
        'length'    =>  '1,1500',
        'message'   =>  '翻译的文本在 1 到 1500 个字符以内!'
    ];
}