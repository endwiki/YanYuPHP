<?php
/**
 * 文章模型
 * User: end_wiki
 * Date: 2017/11/5
 * Time: 17:24
 */
namespace app\api\model;

use src\framework\Config;
use src\framework\Database;
use app\common\exceptions\AddArticleAlreadyFailedException;

class Article {

    /**
     * 新增文章
     * @param string $title 文章标题
     * @param string $content 文章内容
     * @param integer $categoryId 类目ID
     * @param integer $userId 用户ID
     * @return bool
     * @throws AddArticleAlreadyFailedException [300001]新增文章异常
     */
    public static function addArticle($title,$content,$categoryId,$userId){
        $dbConfig = Config::get('database');
        $dbInstance = Database::getInstance($dbConfig['host'],$dbConfig['db'],$dbConfig['user'],$dbConfig['password']);
        $addArticleSql = 'INSERT INTO article SET title=:title,user_id=:user_id,
          content=:content,category_id=:category_id,status=:status,create_time=:create_time,update_time=:update_time';
        $statementObject = $dbInstance->prepare($addArticleSql);
        $insertResult = $statementObject->execute([
            'title'     =>      $title,
            'content'   =>      $content,
            'category_id'   =>  $categoryId,
            'user_id'       =>  $userId,
            'status'        =>      1,
            'create_time'   =>      time(),
            'update_time'   =>      time(),
        ]);
        if(false == $insertResult){
            throw new AddArticleAlreadyFailedException();
        }
        return true;
    }
}