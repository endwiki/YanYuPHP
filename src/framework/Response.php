<?php
/**
 * 响应类
 * User: end_wiki
 * Date: 2017/10/22
 * Time: 19:08
 */
namespace src\framework;

class Response{

    protected static $isCache = false;      // 响应内容是否为缓存

    /**
     * 返回 ajax 响应
     * @param mixed $data 响应数据
     * @return void
     */
    public static function ajaxReturn($data){
        header('Content-type: application/json');
        // 缓存请求,如果本身即为缓存，无需再次缓存直接返回
        $isCacheConfig = Config::get('REQUEST.ON');     // 配置中是否开启缓存
        if(!self::$isCache && $isCacheConfig){
            self::cache($data);
        }
        echo json_encode($data);        // 输出响应
        die();
    }

    /**
     * 设置响应内容缓存旗帜
     * @param bool $isCache 响应内容是否为缓存
     * @return void
     */
    public static function setCacheFlag(bool $isCache){
        self::$isCache = $isCache;
    }

    /**
     * 缓存请求响应
     * @param mixed $data 响应内容
     * @return void
     */
    private static function cache($data){
        Cache::getInstance()->save(
            Route::getUniqueId(),           // 获取请求唯一标识
            serialize($data)
        );
    }


}