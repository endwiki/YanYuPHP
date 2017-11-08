<?php
/**
 * 新增文章接口验证类
 * User: end_wiki
 * Date: 2017/11/5
 * Time: 15:52
 */
namespace app\common\verifications;

use src\framework\Validation;
use app\api\model\Category as CategoryModel;

class ArticleAdd extends Validation{

    protected $title = [
        'require'   =>      true,
        'type'      =>      'string',
        'length'    =>      '1,20',
        'message'   =>      '文章标题必须在 10 到 20 个字符以内!'
    ];
    protected $category_id = [
        'require'   =>      true,
        'type'      =>      'method',
        'class'     =>      'app\\common\\verifications\\ArticleAdd',
        'method_name'=>     'CategoryMustExist',
        'message'   =>      '类目不存在!'
    ];
    protected $content = [
        'require'   =>      false,
        'type'      =>      'String',
        'length'    =>      '0,4000',         // 验证长度
        'message'   =>      '文章内容在 0 到 4000 个汉字以内!',
    ];
    /**
     * 类目必须存在
     * @param integer $category 类目ID
     * @return boolean
     */
    public function categoryMustExist($category){
        if(CategoryModel::categoryHasExist($category)){
            return true;
        }
        return false;
    }
}