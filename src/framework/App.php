<?php
/**
 * 应用类
 * User: end_wiki
 * Date: 2017/10/22
 * Time: 19:37
 */
namespace src\framework;

use src\framework\exceptions\ClassNotFoundException;
use src\framework\exceptions\RequestActionNotFoundException;
use src\framework\exceptions\RequestControllerNotFoundException;
use src\framework\exceptions\RuntimeDirCreateFailedException;
use src\framework\exceptions\TheIpDenyPassException;

class App {

    /**
     * 初始化应用
     * @return void
     */
    public static function init(){
        // 自动加载
        self::autoload();
        // 加载配置
        Config::loadAll();
        // 注册异常和错误处理
        Error::register();
        // 安全检查
        self::checkSafe();
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
     * 类的自动加载
     * @return void
     * @throws ClassNotFoundException [100014]类不存在异常
     */
    public static function autoload(){
        spl_autoload_register(function($clazz){
            $classFile = str_replace('\\','/',$clazz . '.php');
            // 判断文件是否存在
            if(!is_file($classFile)){
                throw new ClassNotFoundException();
            }
            require_once($classFile);
            // 判断类或接口是否存在
            if(!class_exists($clazz) && !interface_exists($clazz)){
                throw new ClassNotFoundException();
            }
        });
    }

    /**
     * 执行应用
     * @return void
     * @throws RequestActionNotFoundException [100019]请求的操作不存在异常
     * @throws RequestControllerNotFoundException [100020]请求的控制器不存在异常
     */
    public static function start(){
        $clazz = substr(APP_PATH,2) . '\\'
            . Route::getModule() . '\\' . Config::get('CONTROLLER_DIR') . '\\' . Route::getController();
        // 反射控制器
        try{
            $controllerClazz = new \ReflectionClass($clazz);
        }catch (ClassNotFoundException $e){
            throw new RequestControllerNotFoundException();
        }

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
            // 如果存在返回结果，则输出响应
            if(!is_null($result)){
                Response::ajaxReturn(['data' =>  $result]);
            }
        }else{
            throw new RequestActionNotFoundException();
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

    /**
     * 安全检查
     * @return bool
     * @throws TheIpDenyPassException [100032]该IP地址被拒绝访问异常
     */
    private static function checkSafe(){
        // 检查 IP 地址
        $ip = Request::getIp();
        $denyIpList = Config::get('SAFE.DENY_IP_LIST');
        if(in_array($ip,$denyIpList)){
            throw new TheIpDenyPassException();
        }
    }

    /**
     * 未捕获的错误处理句柄
     * @param \Error $error 错误类
     * @return void
     */
    public static function notCapturedErrorHandler(\Error $error){
        $errorInfo[] = '错误代码:' . $error->getCode();
        $errorInfo[] = '错误消息:'  . $error->getMessage();
        $errorInfo[] = '错误文件:'  . $error->getFile();
        $errorInfo[] = '错误行号:'  . $error->getLine();
        $errorInfo[] = '错误栈:' . PHP_EOL   . $error->getTraceAsString();
        Error::errorOutput($errorInfo);
    }
}
