<?php
/**
 * 模板短信类
 * User: end_wiki
 * Date: 2017/11/28
 * Time: 17:12
 */
namespace app\api\org;

use app\common\exceptions\SendSMSFailedException;
use src\framework\Config;
use src\framework\Request;

class SMS {

    protected static $config = [];
    protected static $configSetFlag = false;

    /**
     * 初始化配置
     * @param array|null $config 配置
     */
    public static function setConfig(array $config = null){
        if(!is_null($config)){
            self::$config = $config;
        }else{
            self::$config = Config::get('UCPAAS');
        }
        self::$configSetFlag = true;
    }

    /**
     * 发送短信
     * @param String $telephone 手机号
     * @return bool
     * @throws SendSMSFailedException [600001]发送短信失败异常
     * @document http://docs.ucpaas.com/doku.php?id=%E7%9F%AD%E4%BF%A1%E9%AA%8C%E8%AF%81:rest_yz_rest
     */
    public static function send(String $telephone){
        // 设置配置
        if(!self::$configSetFlag){
            self::setConfig();
        }
        $sigParameter = strtoupper(md5(self::$config['ACCOUNT_ID'] . self::$config['AUTH_TOKEN']
            . (date("YmdHis") + 7200)));

        $Authorization = base64_encode(self::$config['ACCOUNT_ID'] . ':' . (date("YmdHis") + 7200));

        $requestUrl = self::$config['BASE_URL'] . self::$config['SOFT_VERSION'] . '/Accounts/'
            . self::$config['ACCOUNT_ID'] . '/Messages/templateSMS?sig=' . $sigParameter;

        $requestData = json_encode([
            'templateSMS'   =>  [
                'appId' =>  self::$config['APP_ID'],
                'param' =>  mt_rand(100000,999999),
                'templateId'    =>  238090,
                'to'    =>      $telephone,
            ]
        ]);

        $header = [
            'Accept:application/json',
            'Content-Type:application/json;charset=utf-8',
            'Authorization:' . $Authorization,
        ];
        $response = Request::sendPostRequest($requestUrl,$requestData,$header);
        $response = json_decode($response,true);
        if(isset($response['resp']['respCode']) && $response['resp']['respCode'] == '000000'){
            return true;
        }else{
            throw new SendSMSFailedException();
        }
    }


}