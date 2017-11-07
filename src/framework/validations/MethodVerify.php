<?php
/**
 * 自定义方法验证类
 * User: end_wiki
 * Date: 2017/11/7
 * Time: 22:24
 */
namespace src\framework\validations;

use app\common\exceptions\ClassNotFoundException;
use app\common\exceptions\MethodNotFoundException;

class MethodVerify implements ValidationInterface {

    /**
     * 验证参数
     * @param array $params 参数
     * @return bool
     * @throws ClassNotFoundException [100005] 类没有找到异常
     * @throws MethodNotFoundException [100006] 成员方法没有找到异常
     */
    public function verify($params){
        // 判断类是否存在
        if(!class_exists($params['rule']['class'])){
            throw new ClassNotFoundException(100005,$params['rule']['class'] . ' 没有找到!');
        }
        $className = $params['rule']['class'];      // 类名
        $class = new $className;                    // 类的实例
        $methods = explode('|',$params['rule']['method_name']);
        // 遍历方法
        foreach($methods as $method){
            // 判断方法是否存在
            if(!method_exists($class,$method)){
                throw new MethodNotFoundException(100006,$className . '::' . $method . '没有找到!');
            }
            if(!$class->$method($params['value'])){
                return false;
            }
        }
        return true;
    }
}