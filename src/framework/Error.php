<?php
/**
 * 错误处理类
 * User: end_wiki
 * Date: 2017/11/21
 * Time: 10:30
 */
namespace src\framework;

use src\framework\exceptions\ExceptionHandler;

class Error extends \Error{

    /**
     * 注册异常处理
     * @return void
     */
    public static function register(){
        error_reporting(E_ALL);
        set_error_handler([__CLASS__,'appError']);
        set_exception_handler([__CLASS__, 'appException']);
        register_shutdown_function([__CLASS__, 'appShutdown']);
    }

    /**
     * 程序错误句柄
     * @param int $no           错误编号
     * @param String $message   错误信息
     * @param String $file      错误文件
     * @param int $line         错误行号
     * @param array $content    错误栈
     * @return void
     * @throws Error
     */
    public static function appError(int $no,String $message,String $file,int $line,array $content = []){
        throw new Error();
    }

    /**
     * 程序异常句柄
     * @param \Exception|\Throwable $e 异常
     * @return mixed
     */
    public static function appException($e){
        $info = [];
        if($e instanceof \Exception){
            $info = [
                'code'  =>  $e->getCode(),
                'message'   =>  $e->getMessage(),
                'file'  =>  $e->getFile(),
                'line'  =>  $e->getLine(),
            ];
        }
        if($e instanceof ExceptionHandler){
            $info = [
                'code'  =>  $e->getCode(),
                'message'   =>  $e->getMessage(),
                'url'   =>  $e->url,
            ];
        }
        Response::ajaxReturn($info);
    }

    /**
     * 程序结束句柄
     */
    public static function appShutdown(){
        // 记录请求日志

    }

}