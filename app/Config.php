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
        'TYPE'      =>  'FILE',                 // 缓存的类型
        'EXPIRATION'    =>  '10',               // 过期时间，单位为秒
    ],
    'SYSTEM_EXECUTION_LIMIT'    =>  0,
    'EXCEPTION_HANDLER'     =>      'app\\common\\ExceptionHandler',
    'SYSTEM_KEY'            =>      '3D4C653A38B73C2DDE77BC6B502908AD',
    // 验证类的命名空间
    'VERIFY_CLASS_NAMESPACE'    =>  'src\\framework\\validations\\',
    // 百度翻译 API 接口
    'baidu_translate_api_ak'    =>  '20171119000097149',
    'baidu_translate_api_sk'    =>  'bFsENQtrNvjpUqFTqygf-',
    'baidu_translate_api_url'   =>  'http://api.fanyi.baidu.com/api/trans/vip/translate',
    'LOG'       =>  [
        'TYPE'      =>  'FILE',
    ]
];
