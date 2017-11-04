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

    public static function post($key = null){
        if($key === null){
            return $_POST;
        }
        return $_POST[$key];
    }

    public static function delete(){

    }

    public static function put($key = null){
        $putData = fopen("php://input","r");
        while($data = fread($putData,1024)){
            $returnData[] = $data;
        }
        return $returnData;
    }

    public static function getMethod(){
        return $_SERVER['REQUEST_METHOD'] ?? NULL;
    }

    public static function getUrl(){
        return $_SERVER['REQUEST_URI'] ?? NULL;
    }
}