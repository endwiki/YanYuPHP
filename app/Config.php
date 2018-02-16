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
    'AUTO_LOAD_CONFIG_DIR'  =>          'app/common/configs',           // 自动加载的配置目录
    'EXCEPTION_HANDLER'     =>      'app\\common\\ExceptionHandler',        // 异常处理句柄
    'SYSTEM_KEY'            =>      '3D4C653A38B73C2DDE77BC6B502908AD',     // 系统安全密钥
    'TIME_ZONE'             =>      'Asia/Shanghai',            // 时区
    // 请求配置
    'REQUEST'               =>      [
        'ON'              =>      false,             // 是否开启请求响应缓存
        'EXPIRATION'      =>      10,               // 请求响应缓存时间
    ],
    // 缓存配置
    'CACHE'             =>      [
        'TYPE'      =>  'REDIS',                 // 缓存的类型
        'EXPIRATION'    =>  '30',               // 过期时间，单位为秒
        'INSTANCE_NAME' =>  'REDIS',            // 实例名称
    ],
    // 日志配置
    'LOG'               =>      [
        'TYPE'      =>  'FILE',
    ],
    // Cookie 配置
    'COOKIE'            =>      [
        'PREFIX'    =>      'sys_',
        'HTTP_ONLY' =>      true,
        'EXPIRE'    =>      30,
        'SET_COOKIE'    =>  true,
    ],
    'ROUTE_MODE'	=>	1,		// 路由兼容模式
    // Session 配置
    'session'       =>          [
        'prefix'        =>      'sys',
        'save_path'      =>      'C:\xampp\tmp',
        'cookie_lifetime'  =>  86400,
    ],
    // 验证码配置
    'CAPTCHA'       =>          [
        'IMAGE_SIZE'    =>  '160,64',
        'FONT_TTF_PATH' =>  './static/font/font.ttf',
    ],
    // 安全配置
    'SAFE'          =>          [
        // 不允许访问的IP列表
        'DENY_IP_LIST'  =>  [

        ]
    ],
    'SYSTEM_EXECUTION_LIMIT'    =>  0,
    'EXCEPTION_HANDLER'     =>      'app\\common\\ExceptionHandler',
    'SYSTEM_KEY'            =>      '3D4C653A38B73C2DDE77BC6B502908AD',
    // 验证类的命名空间
    'VERIFY_CLASS_NAMESPACE'    =>  'src\\framework\\validations\\',
];
