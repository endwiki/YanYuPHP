<?php
/**
 * 单词模型
 * User: end_wiki
 * Date: 2017/11/19
 * Time: 1:24
 */
namespace app\api\model;

use src\framework\Config;
use src\framework\Database;
use src\framework\Request;

class Word {

    /**
     * 添加单词
     * @param String $word 单词
     * @param int $bookId 单词本ID
     * @param int $userId 用户ID
     * @return bool
     */
    public static function add(String $word,int $bookId,int $userId){
        $databaseInstance = Database::getInstance();
        $mean = self::translate($word);         // 通过百度翻译 API 自动获取翻译

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

    /**
     * 请求百度翻译 API 自动翻译
     * @param string $word 将要翻译的文本
     * @param string $from 翻译之前的语言 default 'auto'
     * @param string $to 翻译之后的语言 default 'auto'
     * @return mixed
     */
    public static function translate($word,$from = 'auto',$to = 'auto'){
        // 百度翻译 API 免费额度为每月 200 万
        $appId = Config::get('baidu_translate_api_ak');     // 获取配置中的应用 ID
        $sk = Config::get('baidu_translate_api_sk');        // 获取配置中的应用密钥
        $salt = mt_rand(100000,999999);             // 随机数
        $sign = md5($appId . $word . $salt . $sk);       // 计算签名
        // 在发送 HTTP 请求之前要对各字段做 URL encode
        $word = urlencode($word);
        $from = urlencode($from);
        $to = urlencode($to);
        $appId = urlencode($appId);
        $salt = urlencode($salt);
        $sign = urlencode($sign);
        // 拼接 URL 并发送请求
        $url = Config::get('baidu_translate_api_url') . '?q=' . $word . '&from=' . $from . '&to='
            . $to . '&appid=' . $appId . '&salt=' . $salt . '&sign=' . $sign;
        $result = Request::sendGetRequest($url);
        $result = json_decode($result,true);
        return $result['trans_result'][0]['dst'];
    }
}