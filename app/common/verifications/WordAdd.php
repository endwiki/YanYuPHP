<?php
/**
 * 单词新增接口校验类
 * User: end_wiki
 * Date: 2017/11/19
 * Time: 1:08
 */
namespace app\common\verifications;

use app\api\model\WordBook as WordBookModel;
use src\framework\Validation;

class WordAdd extends Validation{
    protected $word = [
        'require'   =>  true,
        'type'      =>  'String',
        'length'    =>  '1,64',
        'message'   =>  '单词必须在 1 到 64 个字符以内!'
    ];
    protected $mean = [
        'require'   =>  false,
        'type'      =>  'String',
        'length'    =>  '0,255',
        'message'   =>  '解释必须在 0 到 255 个字符以内!'
    ];
    protected $book_id = [
        'require'   =>  true,
        'type'      =>  'Method',
        'class'     =>  'app\\common\\verifications\\WordAdd',
        'method_name'    =>  'bookIdMustExist',
        'message'   =>  '该单词本不存在!'
    ];

    /**
     * 校验单词本ID是否存在
     * @param int $bookId 单词本ID
     * @return bool
     */
    public function bookIdMustExist(int $bookId){
        $result = WordBookModel::hasExistByBookId($bookId);
        if($result){
            return true;
        }
        return false;
    }
}