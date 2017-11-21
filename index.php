<?php
/**
 * 入口文件
 * User: end_wiki
 * Date: 2017/10/22
 * Time: 18:49
 */

define('SYSTEM_VERSION',0.1);
define('SYSTEM_NAME','HOME');
define('LOG_PATH','./logs');
define('APP_PATH','./app');

// 设置时区
date_default_timezone_set('Asia/Shanghai');

// 自动加载
spl_autoload_register(function($clazz){
    $clazz = str_replace('\\','/',$clazz . '.php');
    if(!file_exists($clazz)){
        throw new \app\common\exceptions\ClassNotFoundException();
    }
    require_once $clazz;
});

// 加载配置
\src\framework\Config::load(include APP_PATH . '/common/configs/App.php');

// 注册异常和错误处理
\src\framework\Error::register();


// 检查路由
\src\framework\Route::check();

// 加载应用
\src\framework\App::start();
