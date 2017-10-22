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
define('APP_PATH','./api');

// 设置时区
date_default_timezone_set('Asia/Shanghai');

header('Content-type: application/json');

// 自动加载
spl_autoload_register(function($clazz){
    require  str_replace('\\','/',$clazz . '.php');
});

// 设置错误句柄
//set_error_handler(function(){
//
//});

// 设置异常句柄
//set_exception_handler(function(){
//
//});

// 检查路由
\src\framework\Route::check();

// 加载配置
\src\framework\Config::load(include APP_PATH . '/common/configs/App.php');

// 加载应用
\src\framework\App::start();
