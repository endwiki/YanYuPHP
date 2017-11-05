<?php
/**
 * 类目接口
 * User: end_wiki
 * Date: 2017/11/5
 * Time: 22:06
 */
namespace app\api\controller;

use src\framework\Request;
use app\common\verifications\CategoryAdd;
use app\api\model\Category as CategoryModel;
use src\framework\Response;

class Category extends Authorization {

    /**
     * 类目新增
     * @method POST
     * @api api/category/add
     * @return mixed
     */
    public function add(){
        $params = Request::post();
        (new CategoryAdd)->eachFields($params);
        // 添加类目
        CategoryModel::addCategory($params['name'],$this->uid);
        Response::ajaxReturn([
            'code'      =>      400000,
            'message'   =>      '添加类目成功!',
        ]);
    }

}