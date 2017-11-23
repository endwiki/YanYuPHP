<?php
/**
 * 应用配置
 * User: end_wiki
 * Date: 2017/10/22
 * Time: 19:07
 */
return [
    'CONTROLLER_DIR'        =>      'controller',
    'MODEL_DIR'             =>      'model',
    'SYSTEM_RUNTIME_PATH'       =>      'runtime/',
    'EXCEPTION_HANDLER'     =>      'app\\common\\ExceptionHandler',
    'SYSTEM_KEY'            =>      '3D4C653A38B73C2DDE77BC6B502908AD',
    'TIME_ZONE'             =>      'Asia/Shanghai',
    // 验证类的命名空间
    'VERIFY_CLASS_NAMESPACE'    =>  'src\\framework\\validations\\',
    'database'              =>      include 'Database.php',
];