<?php
/**
 * 正则类
 * User: end_wiki
 * Date: 2017/12/26
 * Time: 10:23
 */
namespace src\framework\tools;

class Regular {

    /**
     * 匹配中国手机号
     * @param bool $matchAll 是否匹配全部
     * @return array
     */
    public function matchTelephoneOfChina(bool $matchAll = false){
        $pattern = '#1(3[0-9]|4[5,7]|5[0-9]|7[0168]|8[0-9])\d{8}#';
        $subject = '18969143101a13198765833a14567431267a17089898178';
        $matches = [];
        if($matchAll){
            preg_match_all($pattern , $subject ,$matches);
        }else{
            preg_match($pattern , $subject ,$matches);
        }
        return $matches;
    }
}