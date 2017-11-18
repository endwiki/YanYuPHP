<?php
/**
 * 添加单词本接口验证类
 * User: end_wiki
 * Date: 2017/11/19
 * Time: 0:34
 */
namespace app\common\verifications;

use src\framework\Validation;

class WordBookAdd extends Validation{
    protected $title = [
        'require'   =>      true,
        'type'      =>      'string',
        'length'    =>      '1,25',
        'message'   =>      '单词本标题必须在 1 到 25 个字符以内!'
    ];
    protected $description = [
        'require'   =>      true,
        'type'      =>      'String',
        'length'    =>      '1,140',
        'message'   =>      '单词本描述必须在 1 到 140 个字符以内!'
    ];
}