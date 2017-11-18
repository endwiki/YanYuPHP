<?php
/**
 * 单词模型
 * User: end_wiki
 * Date: 2017/11/19
 * Time: 1:24
 */
namespace app\api\model;

use src\framework\Database;

class Word {

    /**
     * 添加单词
     * @param String $word 单词
     * @param String $mean 解释
     * @param int $bookId 单词本ID
     * @param int $userId 用户ID
     * @return bool
     */
    public static function add(String $word,String $mean,int $bookId,int $userId){
        $databaseInstance = Database::getInstance();
        $result = $databaseInstance->table('word')
            ->add([
                'word'      =>      $word,
                'mean'      =>      $mean,
                'book_id'   =>      $bookId,
                'user_id'   =>      $userId,
                'create_time'   =>  time(),
                'is_delete' =>  1,
            ]);
        return $result;
    }

    /**
     * 判断单词是否在指定单词本中存在
     * @param $word 单词名称
     * @param integer $bookId 单词本ID
     * @param integer $userId 用户ID
     * @return bool
     */
    public static function hasExistByBook($word,$bookId,$userId){
        $databaseInstance = Database::getInstance();
        $wordInfo = $databaseInstance->table('word')
            ->where([
                'word'  =>  $word,
                'user_id'   =>  $userId,
                'book_id'    =>  $bookId
            ])->fetch();
        if(!$wordInfo){
            return false;
        }
        return true;
    }
}