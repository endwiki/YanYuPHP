<?php
/**
 * 请求类
 * User: end_wiki
 * Date: 2017/10/22
 * Time: 19:05
 */
namespace src\framework;

class Request{

    public static function get(){

    }

    public static function post(){

    }

    public static function delete(){

    }

    public static function put(){

    }

    public static function getMethod(){
        return $_SERVER['REQUEST_METHOD'] ?? NULL;
    }

    public static function getUrl(){
        return $_SERVER['REQUEST_URI'] ?? NULL;
    }
}