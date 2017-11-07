<?php
/**
 * 数值型验证
 * User: end_wiki
 * Date: 2017/11/7
 * Time: 20:26
 */
namespace src\framework\validations;

class NumberVerify implements ValidationInterface {

    public function verify($params){
        // 检测是否为数值
        if(!is_numeric($params['value'])){
            return false;
        }
        // 检测是取值范围
        if(isset($params['rule']['range'])){
            $rangeValue = explode(',',$params['rule']['range']);
            if(count($rangeValue) == 2){
                // 检测最大值和最小值
                list($min,$max) = $rangeValue;
                if($params['value'] < $min || $params['value'] > $max){
                    return false;
                }
            }else{
                // 检测范围
                if(!in_array($params['value'],$rangeValue)){
                    return false;
                }
            }
        }
        return true;
    }
}