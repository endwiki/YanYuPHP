<?php
/**
 * 类目模型
 * User: end_wiki
 * Date: 2017/11/5
 * Time: 16:48
 */
namespace app\api\model;

use src\framework\Config;
use src\framework\Database;

class Category {

    /**
     * 判断类目是否存在
     * @param integer $category 类目ID
     * @return bool
     */
    public static function categoryHasExist($category){
        $dbConfig = Config::get('database');
        $dbInstance = Database::getInstance($dbConfig['host'],$dbConfig['db'],$dbConfig['user'],$dbConfig['password']);
        $queryCategorySql = 'SELECT * FROM category WHERE category_id = :category AND status = 1';
        $statementObject = $dbInstance->prepare($queryCategorySql);
        $statementObject->execute(['category'=>$category]);
        $categoryInfo = $statementObject->fetch(\PDO::FETCH_ASSOC);
        if($categoryInfo){
            return $categoryInfo;
        }
        return false;
    }
}