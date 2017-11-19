<?php
/**
 * 单词接口
 * User: end_wiki
 * Date: 2017/11/19
 * Time: 1:06
 */
namespace app\api\controller;

use app\common\exceptions\WordAddFailedException;
use src\framework\Request;
use app\common\verifications\WordAdd;
use app\api\model\Word as WordModel;
use src\framework\Response;

class Word extends Authorization {

    /**
     * 新增单词接口
     * @method POST
     * @api api/Word/add
     * @return mixed
     * @throws WordAddFailedException [600001] 新增单词失败
     */
    public function add(){
        $params = Request::post();
        // 为了校验是否存在同用户同单词本下存在相同单词
        $params['userId'] = $this->uid;
        (new WordAdd())->eachFields($params);
        $result = WordModel::add($params['word'],$params['book_id'],$this->uid);
        if(!$result){
            throw new WordAddFailedException();
        }
        Response::ajaxReturn([
            'code'  =>     600000,
            'message'   =>  '添加新单词成功',
        ]);
    }

}