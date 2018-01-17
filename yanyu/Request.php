<?php
/**
 * 请求类
 * User: end_wiki
 * Date: 2017/10/22
 * Time: 19:05
 */
namespace yanyu;

class Request{

    /**
     * GET 请求方法
     * @param String 请求路径
     * @return mixed
     */
    public static function sendGetRequest($url){
        $ch = curl_init();
        $isSSL = (substr($url,0,5) == 'https') ? true : false;
        if($isSSL){
            // 信任任何证书
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_PORT, 443);
            // 部分网站一定要启用下面这个选项
            curl_setopt($ch,CURLOPT_FOLLOWLOCATION,true);
        }
        curl_setopt($ch,CURLOPT_TIMEOUT,1.2);
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_HEADER,0);
        $response = curl_exec($ch);
        if($response === false){
            return false;
        }
        curl_close($ch);
        return $response;
    }

    /**
     * POST 请求方法
     * @param String $url 请求路径
     * @param $data 请求数据
     * @param array $header 请求头
     * @return mixed
     */
    public static function sendPostRequest(String $url,$data,array $header = null){

        $ch = curl_init();

        curl_setopt($ch,CURLOPT_URL,$url);
        // 跳过 HTTPS 检查
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

        curl_setopt($ch,CURLOPT_POST,1);

        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);

        // 设置请求头
        if(!is_null($header)){
            curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
        }

        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    /**
     * PUT 请求方法
     * @param String $url 请求地址
     * @param array $params 传参 default null
     * @return mixed
     */
    public static function sendPutRequest(String $url,array $params = null){
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'put');
        curl_setopt($ch,CURLOPT_HTTPHEADER,[
            'X-HTTP-Method-Override:put',
        ]);
        if(!is_null($params)){
            curl_setopt($ch,CURLOPT_POSTFIELDS,$params);
        }
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    public static function get(){
        return $_GET;
    }

    /**
     * 获取请求头
     * @return array|bool|false
     */
    public static function getHeader(){
        $header = apache_request_headers();
        if(apache_request_headers()){
            return $header;
        }else{
            return false;
        }
    }

    /**
     * 获取IP
     * @return String
     */
    public static function getIp(){
        return $_SERVER['REMOTE_ADDR'];
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