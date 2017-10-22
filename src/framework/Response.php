<?php
/**
 * 响应类
 * User: end_wiki
 * Date: 2017/10/22
 * Time: 19:08
 */
namespace src\framework;

class Response{

    public static function ajaxReturn($data){
        header('Content-type: application/json');
        echo json_encode($data);
    }
}