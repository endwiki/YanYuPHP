<?php
/**
 * 验证器
 * User: end_wiki
 * Date: 2017/11/5
 * Time: 15:38
 */
namespace src\framework\Validation;

use app\common\exceptions\VerificationFailedException;

class Validation{

    public function setMap(Array $fields){
        foreach($fields as $field => $value){
            $this->$field = $value;
        }
    }

    public function eachFields($fields){
        // 获取必填项
        $this->verifyRequire($fields);
        // 验证规则
        foreach($fields as $field => $value){
            $rule = isset($this->$field) ? $this->$field : null;
            if(!is_null($rule)){
                $result = $this->verifyRule($value,$rule);
                if($result == false){
                    throw new VerificationFailedException(100003,'字段:' . $field . '验证失败,原因是:'
                        . $rule[count($rule) - 1]);
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
            if('require' == $property[0]){
                if(!isset($fields[$property->name])  && '' != $fields[$property->name]){
                    throw new VerificationFailedException(100003,'字段: ' . $property->name
                        . ' 验证失败,原因是:该字段必填!');
                }
            }
        }
    }

    protected function verifyRule($value,$rule){
        // 检验类型
        switch($rule[1]){
            case 'string':
                $result = false;
                if(is_string($value) && mb_strlen($value,'utf8') <= $rule[2]){
                    $result = true;
                }
                return $result;
                break;
            case 'integer':
                $result = filter_var($value,FILTER_VALIDATE_INT);
                break;
            case 'boolean':
                $result = filter_var($value,FILTER_VALIDATE_BOOLEAN);
                break;
            case 'function':
                if(!isset($rule[2])){
                    throw \Exception($value . ' Call to undefined function!');
                }
                if(!is_callable($rule[2])){
                    throw \Exception($rule[2] . ' callable is false');
                }
                $result = call_user_func($rule[2],$value);
                break;
            case 'method':
                if(!isset($rule[2])){
                    throw new \Exception($value . ' Call to undefined method!');
                }
                if(!method_exists($this,$rule[2])){
                    throw new \Exception($value . ' method don\'t found!');
                }
                $method = $rule[2];
                $result = $this->$method($value);
                break;
            case 'regular':
                $result = $this->isRegular($value);
                break;
            case 'json':
                $result = $this->verifyJson($value);
                break;
            default:
                return true;
        }
        return $result;
    }

    // 验证 JSON 格式
    public function verifyJson($value){
        $result = json_decode($value);
        if(false == $result || null == $result){
            return false;
        }
        return true;
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