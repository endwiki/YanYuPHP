<?php
/**
 * 单词本模型类
 * User: end_wiki
 * Date: 2017/11/19
 * Time: 0:38
 */
namespace app\api\model;

use src\framework\Database;

class WordBook{

    /**
     * 添加单词本
     * @param String $title 单词本标题
     * @param String $description 单词本描述
     * @param int $userId 用户ID
     * @return bool
     */
    public static function add(String $title,String $description,int $userId){
        $databaseInstance = Database::getInstance();
        $result = $databaseInstance->table('word_book')
            ->add([
                'title' =>  $title,
                'description'   =>  $description,
                'user_id'   =>  $userId,
                'create_time'   =>  time(),
                'delete_id' =>  1,
            ]);
        return $result;
    }

    /**
     * 获取单词本列表
     * @param int $userId 用户ID
     * @return mixed
     */
    public static function getList(int $userId){
        $databaseInstance = Database::getInstance();
        $wordBookList = $databaseInstance->table('word_book')
            ->field(['book_id','title','description','create_time'])
            ->where([
                'user_id'   =>  $userId
            ])
            ->limit(10)
            ->fetch();

        return $wordBookList;
    }

    /**
     * 根据单词本ID检查单词本是否存在
     * @param int $bookId 单词本ID
     * @return bool
     */
    public static function hasExistByBookId(int $bookId){
        $databaseInstance = Database::getInstance();
        $bookInfo = $databaseInstance->table('word_book')
            ->where([
                'book_id'  =>   $bookId
            ])->fetch();

        if(!$bookInfo){
            return false;
        }
        return true;
    }
}