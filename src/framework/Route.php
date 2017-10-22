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

    public static function check(){
        $requestUri = substr($_SERVER['REQUEST_URI'],1);
        $requestToken = explode('/',$requestUri);
        // 获取模块、控制器、方法
        list(self::$module,self::$controller,self::$action) = $requestToken;
        // 获取参数
        self::$args = array_splice($requestToken,3);
    }

    public static function getModule(){
        return self::$module;
    }

    public static function getController(){
        return self::$controller;
    }

    public static function getAction(){
        return self::$action;
    }

    public static function getArgs(){
        return self::$args;
    }


}