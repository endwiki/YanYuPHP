<?php
/**
 * 入口文件
 * User: end_wiki
 * Date: 2017/10/22
 * Time: 18:49
 */

define('SYSTEM_VERSION',0.1);
define('SYSTEM_START_TIME',microtime(true));
define('SYSTEM_NAME','HOME');
define('LOG_PATH','./logs');
define('APP_PATH','./app');
define('DEBUG',true);           // 调试模式

// 检查PHP版本
if(PHP_VERSION < '7.0.0'){
    echo 'PHP version is too low,must be above 7.0.0!';
    die();
}
require_once './src/framework/App.php';
use \src\framework\App;
set_time_limit(0);
// 初始化应用
App::init();
// 执行应用
try{
    App::start();
}catch(Error $error){
    // 处理未捕获的错误
    App::notCapturedErrorHandler($error);
}