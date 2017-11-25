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

require_once './src/framework/App.php';

// 初始化应用
\src\framework\App::init();
// 执行应用
\src\framework\App::start();
