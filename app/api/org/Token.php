<?php
/**
 * Token 类
 * User: end_wiki
 * Date: 2017/11/4
 * Time: 16:34
 */
namespace app\api\org;

use src\framework\Config;
use app\common\exceptions\TokenCheckFailedException;
use app\common\exceptions\TokenOutTimeException;

class Token {
    protected static $salt;
    /**
     * 创建Token
     * @method POST
     * @param String $uuid 用户唯一标识
     * @param Integer $expiration 过期时间间隔
     * @param String $encryption 加密风格 Default 'JWT'
     * @param Boolean $isAdmin 是否为管理员 Default false
     * @return mixed
     */
    public static function createToken($uuid,$expiration = 3600,$encryption = 'JWT',$isAdmin = false){
        // JWT 头信息
        $header = ['type'=>'JWT','alg'=>'HS256'];
        // JWT 负载信息-包括Token内各类数据
        $payload = [
            'iss' =>	'qinzen',			// 签发者
            'sub'	=>	'weixin',			// 所面向的用户
            'exp'	=>	$expiration,		// 过期时间
            'nbf'	=>	time(),				// 在此时间之前该签名无效
            'iat'	=>	time(),				// 签发的时间
            'jti'	=>	microtime(),		// 唯一身份标示
            'admin'	=>	$isAdmin,			// 是否为管理员(淘客)
            'uuid'	=>	$uuid,				// 用户唯一标示
        ];
        // 加密头信息
        $encryptHeader = base64_encode(json_encode($header,true));
        // 加密负载信息
        $encryptPayload = base64_encode(json_encode($payload,true));
        // 生成签名
        $signature = hash('sha256',$encryptHeader . $encryptPayload . Config::get('SYSTEM_KEY'));
        $token = $encryptHeader . '.' . $encryptPayload . '.' . $signature;
        return $token;
    }
    /**
     * 校验 Token
     * @param String $token Token
     * @throws TokenCheckFailedException  Token 非法
     * @throws TokenOutTimeException    Token 超时
     * @return mixed
     */
    public static function checkToken($token){
        // 解析token
        $tokenArr = explode('.',$token);
        if(3 !== count($tokenArr)){
            throw new TokenCheckFailedException();
        }
        // $header = json_decode(base64_decode($tokenArr[0]));
        $payload = json_decode(base64_decode($tokenArr[1]));
        // 检查是否过期
        $now = time();
        if($now < $payload->nbf || $now > ($payload->iat + $payload->exp)){
            throw new TokenOutTimeException();
        }
        // 检查是否被篡改
        $signature = hash('sha256',$tokenArr[0] . $tokenArr[1] . Config::get('SYSTEM_KEY'));
        if($tokenArr[2] !== $signature){
            throw new TokenCheckFailedException();
        }else{
            return $payload->uuid;
        }
    }
}