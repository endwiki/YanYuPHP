<?php
/**
 * 自定义方法验证类
 * User: end_wiki
 * Date: 2017/11/7
 * Time: 22:24
 */
namespace src\framework\validations;

class MethodVerify implements ValidationInterface {

    public function verify($params){
        $class = $params['rule']['class'];
        $methods = explode('|',$params['rule']['method_name']);
        foreach($methods as $method){
            if(!(new $class)->$method($params['value'])){
                return false;
            }
        }
        return true;
    }
}