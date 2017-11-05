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
use app\common\exceptions\AddCategoryAlreadyFailedException;
use app\common\exceptions\CategoryNameAlreadyExistException;

class Category {

    /**
     * 判断指定 ID 类目是否存在
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

    /**
     * 查询指定用户指定类目名称是否存在
     * @param string $name 类目名称
     * @param integer $userId 用户ID
     * @return bool
     */
    public static function categoryNameHasExist($name,$userId){
        $dbConfig = Config::get('database');
        $dbInstance = Database::getInstance($dbConfig['host'],$dbConfig['db'],$dbConfig['user'],$dbConfig['password']);
        $queryCategorySql = 'SELECT * FROM category WHERE name = :category_name 
            AND user_id = :user_id AND status = :status';
        $statementObject = $dbInstance->prepare($queryCategorySql);
        $statementObject->execute([
            'category_name'  =>  $name,
            'user_id'        =>     $userId,
            'status'        =>  1,
        ]);
        $categoryInfo = $statementObject->fetch(\PDO::FETCH_ASSOC);
        if($categoryInfo){
            return $categoryInfo;
        }
        return false;
    }

    /**
     * 添加类目
     * @param string $name 类目名称
     * @param integer $userId 用户ID
     * @throws AddCategoryAlreadyFailedException [400001]类目新增失败
     * @throws CategoryNameAlreadyExistException
     * @return bool
     */
    public static function addCategory($name,$userId){
        // 检查类目名是否已经存在
        if(self::categoryNameHasExist($name,$userId)){
            throw new CategoryNameAlreadyExistException();
        }
        // 添加类目
        $dbConfig = Config::get('database');
        $dbInstance = Database::getInstance($dbConfig['host'],$dbConfig['db'],$dbConfig['user'],$dbConfig['password']);
        $addCategorySql = 'INSERT INTO category SET `name` = :category_name,`user_id` = :user_id, 
          `status` = :status,`create_time` = :create_time';
        $statementObject = $dbInstance->prepare($addCategorySql);
        $insertResult = $statementObject->execute([
            'category_name'     =>      $name,
            'user_id'           =>      $userId,
            'status'            =>      1,
            'create_time'       =>      time(),
        ]);
        if(!$insertResult){
            throw new AddCategoryAlreadyFailedException();
        }
        return true;
    }
}