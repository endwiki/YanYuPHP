<?php
/**
 * 应用类
 * User: end_wiki
 * Date: 2017/10/22
 * Time: 19:37
 */
namespace src\framework;

use src\framework\exceptions\RuntimeDirCreateFailedException;

class App {

    /**
     * 初始化应用
     * @return void
     */
    public static function init(){
        // 加载配置
        Config::load(include APP_PATH . '/common/configs/App.php');
        // 注册异常和错误处理
        Error::register();
        // 加载路由配置
        require_once APP_PATH . '/common/configs/Route.php';
        // 执行时间
        if(!Config::get('SYSTEM_EXECUTION_LIMIT')){
            set_time_limit(0);
        }
        // 设置时区
        date_default_timezone_set(Config::get('TIME_ZONE'));
        // 初始化目录
        self::initDir();
        // 检查路由
        Route::check();
        // 如果存在缓存则读取并响应
        $cache = Cache::getInstance();
        $uniqueId = Route::getUniqueId();
        if($cache->isExist($uniqueId) && Config::get('REQUEST.ON')) {
            $response = $cache->read($uniqueId);
            Response::setCacheFlag(true);
            Response::ajaxReturn($response);
        }
        Response::setCacheFlag(false);
    }

    /**
     * 执行应用
     * @return void
     */
    public static function start(){
        $clazz = substr(APP_PATH,2) . '\\'
            . Route::getModule() . '\\' . Config::get('CONTROLLER_DIR') . '\\' . Route::getController();
        // 反射控制器
        $controllerClazz = new \ReflectionClass($clazz);
        // 检查方法是否存在
        if($controllerClazz->hasMethod(Route::getAction())){
            // 反射方法
            $reflectionMethod  = $controllerClazz->getMethod(Route::getAction());
            // 检查是否带有参数
            $ReflectionParameter = $reflectionMethod->getParameters();
            // 反射控制器
            if(!$ReflectionParameter){
                $result = $reflectionMethod->invoke(new $clazz);
            }else{
                $result = $reflectionMethod->invokeArgs(new $clazz,Route::getArgs());
            }
            // 输出响应
            Response::ajaxReturn(['data' =>  $result]);
        }
    }

    /**
     * 初始化目录
     * @return void
     * @throws RuntimeDirCreateFailedException [100012]运行时目录创建失败
     */
    private static function initDir(){
        $runtimeDir = Config::get('SYSTEM_RUNTIME_PATH');
        File::makeDir($runtimeDir,true);      // 运行时目录
        // 日志目录
        $logDir = $runtimeDir . 'logs/' . Date('Y') . '/' . Date('m') . '/' . Date('d');
        File::makeDir($logDir,true);
        // 创建日志文件
        $fileName = Date('YmdH') . '.log';
        File::textWrite([],$logDir . '/' . $fileName);
        // 创建缓存目录
        $cacheDir = $runtimeDir . 'caches/';
        File::makeDir($cacheDir,true);
    }
}
