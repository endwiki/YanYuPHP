<?php
/**
 * 路由类
 * User: end_wiki
 * Date: 2017/10/22
 * Time: 19:03
 */
namespace src\framework;

class Route{

    private static $module;
    private static $controller;
    private static $action;
    private static $args;

    /**
     * 检查路由
     * @return void
     */
    public static function check(){
        $requestUri = substr($_SERVER['REQUEST_URI'],1);
        // 去除请求 URL 中的参数
        if(strpos($requestUri,'?')){
            $requestUri = substr($requestUri,0,strpos($requestUri,'?'));
        }
        // 获取模块、控制器、方法
        $requestToken = explode('/',$requestUri);
        $requestToken = array_splice($requestToken,count($requestToken) - 3,3);
        list(self::$module,self::$controller,self::$action) = $requestToken;
        // 获取参数
        self::$args = array_splice($requestToken,3);
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