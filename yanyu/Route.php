<?php
/**
 * 路由类
 * User: end_wiki
 * Date: 2017/10/22
 * Time: 19:03
 */
namespace yanyu;

use yanyu\exceptions\RequestModuleNotFoundException;
use yanyu\exceptions\RouteMethodNotFoundException;
use yanyu\exceptions\RouteMethodNotMatchException;
use yanyu\exceptions\RouteRuleNotMissException;

class Route{

    private static $module;
    private static $controller;
    private static $action;
    private static $args;
    private static $rule;                   // 路由规则
    // 不支持 HEAD 方法
    private static $methods = ['GET','POST','PUT','DELETE',
        'PATCH','COPY','OPTIONS','LINK','UNLINK','PURGE','LOCK','UNLOCK','PROPFIND',
        'VIEW'];

    /**
     * 检查路由
     * @return void
     * @throws RouteRuleNotMissException [100016]路由规则不匹配异常
     * @throws RequestModuleNotFoundException [100021]请求的模块不存在
     */
    public static function check(){
		// 路由兼容模式
		$routeMode = Config::get('ROUTE_MODE');
		if($routeMode === 1){
			$requestUri = $_GET['s'];
			list(self::$module,self::$controller,self::$action) = explode('/',$requestUri);
		}else{
			$requestUri = substr($_SERVER['REQUEST_URI'],1);	
		}
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
            // 检查模块是否存在
            $modulePath = APP_PATH . '/' . $requestToken[0];
            if(!is_dir($modulePath)){
                throw new RequestModuleNotFoundException();
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
     * @param mixed $url 路由地址
     * @param String|array $method HTTP 方法
     * @param array $params 路由参数
     * @return void
     * @throws RouteMethodNotFoundException [100017] 路由方法不存在异常
     * @throws RouteMethodNotMatchException [100018] 路由方法不匹配异常
     */
    public static function setRule(String $exp,$url,$method,array $params = []){
        // 检查方法是否存在
        if(is_array($method)){
            foreach($method as $item => $value){
                $method[$item] = strtoupper($value);        // 统一大小写
                if(!in_array($method[$item],self::$methods)){
                    throw new RouteMethodNotFoundException();
                }
            }
        }else{
            $method = strtoupper($method);              // 统一大小写
            if(!in_array($method,self::$methods)){
                throw new RouteMethodNotFoundException();
            }
        }

        // 检查路由方法是否匹配
        $requestMethod = Request::getMethod();
        // 允许单个方法通过
        if(is_string($method) && $method != $requestMethod){
            throw new RouteMethodNotMatchException();
        }
        // 允许多个方法通过
        if(is_array($method) && !in_array($requestMethod,$method)){
            throw new RouteMethodNotMatchException();
        }
        // 闭包支持
        if(is_callable($url)){
            $func = $url;   // 更改名称，增加可读性
            call_user_func($func);
            die();
        }
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
