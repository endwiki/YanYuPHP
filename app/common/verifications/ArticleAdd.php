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

    protected $title = ['require', 'string',1,20,'文章标题必须在 10 到 20 个字符以内!'];
    protected $content = [null, 'string',0,4000,'文章内容在 0 到 4000 个汉字以内!'];
    protected $category_id = ['require','method','CategoryMustExist','类目不存在!'];

    /**
     * 类目必须存在
     * @param integer $category 类目ID
     * @return boolean
     */
    protected function categoryMustExist($category){
        if(CategoryModel::categoryHasExist($category)){
            return true;
        }
        return false;
    }
}