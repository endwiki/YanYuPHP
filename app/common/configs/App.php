<?php
/**
 * 应用配置
 * User: end_wiki
 * Date: 2017/10/22
 * Time: 19:07
 */
return [
    'CONTROLLER_DIR'        =>      'controller',                       // 控制器目录
    'MODEL_DIR'             =>      'model',                            // 模块目录
    'SYSTEM_RUNTIME_PATH'       =>      'runtime/',                     // 运行时目录
    'EXCEPTION_HANDLER'     =>      'app\\common\\ExceptionHandler',        // 异常处理句柄
    'SYSTEM_KEY'            =>      '3D4C653A38B73C2DDE77BC6B502908AD',     // 系统安全密钥
    'TIME_ZONE'             =>      'Asia/Shanghai',            // 时区
    // 请求配置
    'REQUEST'               =>      [
        'ON'              =>      true,             // 是否开启请求响应缓存
        'EXPIRATION'      =>      10,               // 请求响应缓存时间
    ],
    // 缓存配置
    'CACHE'             =>      [
        'TYPE'      =>  'FILE',                 // 缓存的类型
        'EXPIRATION'    =>  '10',               // 过期时间，单位为秒
    ],
    // 验证类的命名空间
    'VERIFY_CLASS_NAMESPACE'    =>  'src\\framework\\validations\\',
    // 数据库配置
    'database'              =>      include 'Database.php',
];