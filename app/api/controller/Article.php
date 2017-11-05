<?php
/**
 * 文章接口
 * User: end_wiki
 * Date: 2017/11/5
 * Time: 14:38
 */
namespace app\api\controller;

use app\common\verifications\ArticleAdd;
use src\framework\Request;
use app\api\model\Article as ArticleModel;
use src\framework\Response;

class Article extends Authorization {

    /**
     * 新增文章
     * @method POST
     * @api api/article/add
     * @return mixed
     */
    public function add(){
        $params = Request::post();
        (new ArticleAdd())->eachFields($params);
        //  新增文章
        ArticleModel::addArticle($params['title'],$params['content'],
            $params['category_id'],$this->uid);

        Response::ajaxReturn([
            'code'  =>      300000,
            'message'   =>  '新增文章成功!',
        ]);
    }

}