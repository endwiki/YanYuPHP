<?php
/**
 * 路由类
 * User: end_wiki
 * Date: 2017/10/22
 * Time: 19:03
 */
namespace src\framework;

use src\framework\exceptions\RouteRuleNotMissException;

class Route{

    private static $module;
    private static $controller;
    private static $action;
    private static $args;
    private static $rule;                   // 路由规则

    /**
     * 检查路由
     * @return void
     * @throws RouteRuleNotMissException [1000016]路由规则不匹配异常
     */
    public static function check(){
        $requestUri = substr($_SERVER['REQUEST_URI'],1);
        // 去除请求 URL 中的参数
        if(strpos($requestUri,'?')){
            $requestUri = substr($requestUri,0,strpos($requestUri,'?'));
        }
        // 检查是否设置了路由规则
        if(!isset(self::$rule)){
            // 获取当前请求的模块、控制器、方法
            $requestToken = explode('/',$requestUri);
            $requestToken = array_splice($requestToken,count($requestToken) - 3,3);
            // 检查路由规则是否匹配
            if(count($requestToken) < 3){
                throw new RouteRuleNotMissException();
            }
            list(self::$module,self::$controller,self::$action) = $requestToken;
            // 获取参数
            self::$args = array_splice($requestToken,3);
        }else{
            // 匹配路由规则
            self::checkRule($requestUri);
        }
    }

    /**
     * 获取请求唯一ID
     * @return String
     */
    public static function getUniqueId(){
        // TODO: 在有用户的场景下，唯一标识无效
        // 对请求URL，请求参数做散列计算，得出唯一标识
        $requestUrl = self::getModule() . self::getController() . self::getAction();
        $args = self::getArgs();
        $argStr = '';
        if(count($args) > 0){
            foreach($args as $index => $arg){
                $argStr .= $arg;
            }
        }
        $uniqueId = md5($requestUrl . $argStr);
        return $uniqueId;
    }

    /**
     * 设置路由规则
     * @param String $exp 路由表达式
     * @param String $url 路由地址
     * @param String $method HTTP 方法
     * @param array $params 路由参数
     * @return void
     */
    public static function setRule(String $exp,String $url,String $method = 'GET',array $params = []){
        self::$rule[$exp] = $url;
    }

    /**
     * 匹配路由规则
     * @param String $requestUri
     * @throws RouteRuleNotMissException [100016]路由规则不匹配异常
     */
    public static function checkRule(String $requestUri){
        // 检查是否存在对应的路由规则
        if(!isset(self::$rule[$requestUri])){
            throw new RouteRuleNotMissException();
        }
        $realUrl = self::$rule[$requestUri];
        list(self::$module,self::$controller,self::$action) = explode('/',$realUrl);
    }

    /**
     * 获取请求模块名称
     * @return String
     */
    public static function getModule(){
        return self::$module;
    }

    /**
     * 获取请求控制器名称
     * @return String
     */
    public static function getController(){
        return self::$controller;
    }

    /**
     * 获取请求方法名称
     * @return String
     */
    public static function getAction(){
        return self::$action;
    }

    /**
     * 获取请求参数
     * @return mixed
     */
    public static function getArgs(){
        return self::$args;
    }


}