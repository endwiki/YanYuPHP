<?php
/**
 * 验证器
 * User: end_wiki
 * Date: 2017/11/5
 * Time: 15:38
 */
namespace src\framework;

use app\common\exceptions\VerificationFailedException;
use app\common\exceptions\VerifyTypeNotFoundException;

class Validation{

    protected $code;
    protected $message;

    /**
     * 遍历字段
     * @param array $fields 参与验证的字段
     * @return bool
     * @throws VerificationFailedException [100003] 验证失败异常
     */
    public function eachFields($fields){
        // 获取必填项
        $this->verifyRequire($fields);
        // 验证规则
        foreach($fields as $field => $value){
            $rule = isset($this->$field) ? $this->$field : null;
            if(!is_null($rule)){
                // 判断是否为多重校验
                if(isset($rule[0]) && is_array($rule[0])){
                    foreach($rule as $item => $ruleValue){
                        $result = $this->verifyRule($value,$ruleValue,$fields);
                        if($result == false){
                            break;
                        }
                    }
                }else{
                    $result = $this->verifyRule($value,$rule,$fields);
                }
                if($result == false){
                    $message = isset($rule['message']) ? $rule['message'] : $ruleValue['message'];
                    throw new VerificationFailedException(100003,'字段:' . $field . '验证失败,原因是:'
                        . $message);
                }

            }
        }
        return true;
    }


    // 验证是否必填
    protected function verifyRequire($fields){
        $reflectClass = new \ReflectionClass($this);
        $properties = $reflectClass->getProperties();
        foreach($properties as $property){
            $propertyName = $property->name;
            $property = $this->$propertyName;
            // 判断是否存在多重校验的情况
            if(!isset($property['require'])){
                $isRequire = $property[0]['require'];
            }else{
                $isRequire = $property['require'];
            }
            if($isRequire){
                if(!isset($fields[$propertyName])){
                    throw new VerificationFailedException(100003,'字段: ' . $propertyName
                        . ' 验证失败,原因是:该字段必填!');
                }
            }
        }
    }

    /**
     * 验证指定值的规则
     * @param mixed $value  验证的值
     * @param string|array $rule 验证的规则
     * @param array $fields 接口的字段,以备参数注入
     * @return bool|mixed
     * @throws VerifyTypeNotFoundException [100004]没有找到对应的验证方法
     * @throws \Exception
     */
    protected function verifyRule($value,$rule,$fields){
        // 检测验证类型是否存在
        $namespace = Config::get('VERIFY_CLASS_NAMESPACE');
        $clazz = ucfirst(strtolower($rule['type'])) . 'Verify';
        if(!class_exists($namespace . $clazz)){
            throw new VerifyTypeNotFoundException(100004,'没有找到[' . $clazz . ']这个验证方法!');
        }
        // 验证并返回结果
        $clazz = $namespace . $clazz;
        return (new $clazz)->verify([
            'value' =>      $value,
            'rule'  =>      $rule,
            'fields'    =>  $fields,
        ]);
    }

    // 验证手机号码
    public function verifyPhone($phone){
        if(preg_match("/^1[34578]{1}\d{9}$/",$phone)){
            return true;
        }else{
            return false;
        }
    }

}