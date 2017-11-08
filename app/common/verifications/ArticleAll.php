<?php
/**
 * 文章列表校验类
 * User: end_wiki
 * Date: 2017/11/8
 * Time: 17:15
 */
namespace app\common\verifications;

use src\framework\Validation;

class ArticleAll extends Validation{
    protected $page = [
        'require' =>      true,
        'type'    =>      'Number',
        'range'     =>      '1,10000',
        'message'   =>      '文章页数不再范围内',
    ];
    protected $size = [
        'require'   =>  true,
        'type'      =>  'Number',
        'range'     =>  '10,20,30,40,50,60,70,80,100',
        'message'   =>  '列表每页数量为一百以内 10 的倍数',
    ];

}