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

    public static function textTranslate(String $text,int $userId){
        // 文本是否在数据库中存在纪录
        $textHash = md5(hash('sha256',$text));
        $databaseInstance = Database::getInstance();
        $queryResult = $databaseInstance->table('text_translate_result')
            ->field(['translate_text'])
            ->where([
                'text_hash' =>  $textHash
            ])->fetch();
        // 如果存在纪录,直接返回结果
        if($queryResult){
            return $queryResult['translate_text'];
        }
        // 如果不存在纪录,则调用百度翻译 API 查询结果并纪录到数据库
        if($queryResult == false){
            $queryResult = self::translate($text);
            $databaseInstance->table('text_translate_result')
                ->add([
                    'text_hash' =>  $textHash,
                    'translate_text'    =>  $queryResult,
                    'create_time'   =>  time(),
                    'user_id'  =>    $userId,
                ]);
        }

        return $queryResult;
    }

    /**
     * 请求百度翻译 API 自动翻译
     * @param string $text 将要翻译的文本
     * @param string $from 翻译之前的语言 default 'auto'
     * @param string $to 翻译之后的语言 default 'auto'
     * @return mixed
     */
    private static function translate($text,$from = 'auto',$to = 'auto'){
        // 百度翻译 API 免费额度为每月 200 万
        $appId = Config::get('baidu_translate_api_ak');     // 获取配置中的应用 ID
        $sk = Config::get('baidu_translate_api_sk');        // 获取配置中的应用密钥
        $salt = mt_rand(100000,999999);             // 随机数
        $sign = md5($appId . $text . $salt . $sk);       // 计算签名
        // 在发送 HTTP 请求之前要对各字段做 URL encode
        $text = urlencode($text);
        $from = urlencode($from);
        $to = urlencode($to);
        $appId = urlencode($appId);
        $salt = urlencode($salt);
        $sign = urlencode($sign);
        // 拼接 URL 并发送请求
        $url = Config::get('baidu_translate_api_url') . '?q=' . $text . '&from=' . $from . '&to='
            . $to . '&appid=' . $appId . '&salt=' . $salt . '&sign=' . $sign;
        $result = Request::sendGetRequest($url);
        $result = json_decode($result,true);
        return $result['trans_result'][0]['dst'];
    }
}