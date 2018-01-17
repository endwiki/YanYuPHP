<?php
/**
 * 字符串验证类
 * User: end_wiki
 * Date: 2017/11/7
 * Time: 21:41
 */
namespace yanyu\validations;

class StringVerify implements ValidationInterface{

    // 验证范围
    public function verifyRange($value,$range){
        $range = explode(',',$range);
        if(!in_array($value,$range)){
            return false;
        }
        return true;
    }

    // 验证长度
    public function verifyLength($value,$range){
        $length = mb_strlen($value,'utf8');
        // 验证单个指定长度
        if(!strpos($range,',')){
            if($length != (int)$range){
                return false;
            }
            return true;
        }
        // 验证长度范围
        list($minLength,$maxLength) = explode(',',$range);
        if($length < $minLength || $length > $maxLength){
            return false;
        }
        return true;
    }

    // 验证字符串
    public function verify($params){
        if(isset($params['rule']['range'])){
            if(!$this->verifyRange($params['value'],$params['rule']['range'])){
                return false;
            }
        }
        if(isset($params['rule']['length'])){
            if(!$this->verifyLength($params['value'],$params['rule']['length'])){
                return false;
            }
        }
        return true;
    }
}