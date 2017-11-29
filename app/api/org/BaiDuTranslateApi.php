<?php
/**
 * 百度翻译 API
 * User: end_wiki
 * Date: 2017/11/29
 * Time: 16:37
 */
namespace app\api\org;

use src\framework\Config;
use src\framework\Request;

class BaiDuTranslateApi {

    /**
     * 翻译文本接口
     * @param String $text 文本
     * @param String $from 源语言
     * @param String $to 目标语言
     * @return string
     */
    public function translate(String $text,String $from = 'auto',String $to = 'auto'){
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
        // 发生错误
        if(isset($result['error_code'])){
            return 'NUL';
        }
        return $result['trans_result'][0]['dst'];
    }
}